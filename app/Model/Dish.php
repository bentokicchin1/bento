<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    protected static function boot()
    {
       parent::boot();
       static::deleting(function($dish) {
         foreach ($dish->weeklyMenu()->get() as $weeklyMenu) {
            $weeklyMenu->delete();
         }
         foreach ($dish->order_items()->get() as $order_items) {
            $order_items->delete();
         }
       });
    }
    public function dishType()
    {
        return $this->belongsTo('App\Model\DishType');
    }

    public function weeklyMenu()
    {
        return $this->hasMany('App\Model\WeeklyDishList');
    }

    public function order_items()
    {
        return $this->hasMany('App\Model\OrderItem');
    }

    public function getDishListfromDb($orderTypeId, $date)
    {
      $dishes = array();
        if ($date == 'all') {
            $currentDate = date('Y-m-d');
            $daysArray = WeeklyDishList::getDatesForThisWeek();
            $dishes = DB::table('dishes')
                ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'weekly_dish_lists.date', 'dishes.price', 'dish_types.name as dish_type_name')
                ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
                ->wherein('weekly_dish_lists.date',$daysArray)
                ->where('weekly_dish_lists.date','>=',$currentDate)
                ->where('dishes.deleted_at',null)
                ->orderby('dish_types.id')
                ->get()->toArray();
        } else {
          $currentTime= date('h:i a');
          if(($orderTypeId==config('constants.ORDER_TYPE_LUNCH') && strtotime($currentTime)<=strtotime(config('constants.LUNCH_ORDER_MAX_TIME'))) || ($orderTypeId==config('constants.ORDER_TYPE_DINNER') && strtotime($currentTime)<=strtotime(config('constants.DINNER_ORDER_MAX_TIME')))) {
            $dishes = DB::table('dishes')
                  ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'weekly_dish_lists.date', 'dishes.price', 'dish_types.name as dish_type_name')
                  ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                  ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                  ->where('weekly_dish_lists.date', '=', $date)
                  ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
                  ->where('dishes.deleted_at',null)
                  ->orderby('dish_types.id')
                  ->get()->toArray();
            }
        }
        return $dishes;
    }

    public function getDishListfromDbForAdmin($orderTypeId,$orderDate)
    {
      $dishes = DB::table('dishes')
            ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'weekly_dish_lists.date', 'dishes.price', 'dish_types.name as dish_type_name')
            ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
            ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
            ->where('weekly_dish_lists.date', '=', $orderDate)
            ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
            ->where('dishes.deleted_at',null)
            ->orderby('dish_types.id')
            ->get()->toArray();
        return $dishes;
    }


    public function getDefaultDishListfromDb($orderTypeId)
    {
        $dishes = array();
        $currentDate = date('Y-m-d');
        $daysArray = WeeklyDishList::getDatesForThisWeek();
        echo "<pre/>";
        print_r($daysArray);
        $dishes = DB::table('dishes')
            ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'weekly_dish_lists.date', 'dishes.price', 'dish_types.name as dish_type_name', 'dish_types.food_type as dish_food_type')
            ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
            ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
            ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
            ->wherein('weekly_dish_lists.date',$daysArray)
            ->where('weekly_dish_lists.date','>=',$currentDate)
            ->where('dishes.deleted_at',null)
            ->where('weekly_dish_lists.is_default','Y')
            ->orderby('dish_types.id')
            ->get()->toArray();
        return $dishes;
    }


    public function abc(){
       return $this->belongsTo('App\dishType');
    }

    /**
     * Return dish detail by id.
     * @param (int)dish id
     * @return (object) dish details
     */
    public function getDishDetailById($dishId)
    {
        return Dish::select('price', 'name')->where('id', $dishId)->first();
    }
}
