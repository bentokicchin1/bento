<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyDishList extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    public function order_type()
    {
        return $this->belongsTo('App\Model\OrderType');
    }

    public function dish()
    {
        return $this->belongsTo('App\Model\Dish');
    }

    public static function getTotalWeekMenuData($weekDays)
    {
        $menuArray = array();
        $weeklyMenu = DB::table('weekly_dish_lists')
                ->select("day","date","order_types.name as orderType","dishes.name as dish","dish_types.name as dishType")
                ->leftjoin("order_types","order_types.id","=","weekly_dish_lists.order_type_id")
                ->leftjoin("dishes","dishes.id","=","weekly_dish_lists.dish_id")
                ->leftjoin("dish_types","dish_types.id","=","dishes.dish_type_id")
                ->whereIn('weekly_dish_lists.date', $weekDays)
                ->orderBy("weekly_dish_lists.date","ASC")
                ->get();
        if(!empty($weeklyMenu)){
            foreach($weeklyMenu as $menu){
                if(!array_key_exists($menu->date,$menuArray)){
                    $menuArray[$menu->date] = array();
                    $menuArray[$menu->date][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->orderType,$menuArray[$menu->date])) {
                    $menuArray[$menu->date][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->dishType,$menuArray[$menu->date][$menu->orderType])) {
                    $menuArray[$menu->date][$menu->orderType][$menu->dishType] = array();
                }
                array_push($menuArray[$menu->date][$menu->orderType][$menu->dishType],$menu->dish);
            }
        }
        return $menuArray;
    }

    public static function getDatesForThisWeek()
    {
        $week = array();
        $weekDays = config('constants.days');
        foreach($weekDays as $day){
          if(date('l')==='Sunday'){
            array_push($week,date( 'Y-m-d', strtotime( $day.' next week' ) ));
          }else{
            array_push($week,date( 'Y-m-d', strtotime( $day.' this week' ) ));
          }
        }
        return $week;
    }
}
