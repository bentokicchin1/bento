<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyDishList extends Model
{
    public function order_type()
    {
        return $this->belongsTo('App\Model\OrderType');
    }

    public function dish()
    {
        return $this->belongsTo('App\Model\Dish');
    }

    public static function getTotalWeekMenuData()
    {
        $menuArray = array();
        $weeklyMenu = DB::table('weekly_dish_lists')
                ->select("day","order_types.name as orderType","dishes.name as dish","dish_types.name as dishType")
                ->leftjoin("order_types","order_types.id","=","weekly_dish_lists.order_type_id")
                ->leftjoin("dishes","dishes.id","=","weekly_dish_lists.dish_id")
                ->leftjoin("dish_types","dish_types.id","=","dishes.dish_type_id")
                ->orderBy("day","ASC")
                ->get();

        if(!empty($weeklyMenu)){
            foreach($weeklyMenu as $menu){
                if(!array_key_exists($menu->day,$menuArray)){
                    $menuArray[$menu->day] = array();
                    $menuArray[$menu->day][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->orderType,$menuArray[$menu->day])) {
                    $menuArray[$menu->day][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->dishType,$menuArray[$menu->day][$menu->orderType])) {
                    $menuArray[$menu->day][$menu->orderType][$menu->dishType] = array();
                }
                array_push($menuArray[$menu->day][$menu->orderType][$menu->dishType],$menu->dish);
            }
        }
        return $menuArray;
    }
}
