<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    public function dishType()
    {
        return $this->belongsTo('App\Model\DishType');
    }

    public function weeklyMenu()
    {
        return $this->hasMany('App\Model\WeeklyDishList');
    }

    public function getDishListfromDb($orderTypeId, $day)
    {
        if ($day == 'all') {
            $dishes = DB::table('dishes')
                ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'dishes.price', 'dish_types.name as dish_type_name')
                ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
                ->orderby('weekly_dish_lists.id')
                ->get()->toArray();
        } else {
            $dishes = DB::table('dishes')
                ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                ->select('dishes.id', 'dishes.dish_type_id', 'weekly_dish_lists.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'dishes.price', 'dish_types.name as dish_type_name')
                ->where('weekly_dish_lists.day', '=', $day)
                ->where('weekly_dish_lists.order_type_id', '=', $orderTypeId)
                ->get()->toArray();
        }
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
