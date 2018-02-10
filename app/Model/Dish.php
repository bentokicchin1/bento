<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    //

    public function getDishListfromDb($orderTypeId, $day)
    {
        if ($day == 'all') {
            $dishes = DB::table('dishes')
                ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                ->select('dishes.id', 'dishes.dish_type_id', 'dishes.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'dishes.price', 'dish_types.name as dish_type_name')
                ->where('dishes.order_type_id', '=', $orderTypeId)
                ->orderby('weekly_dish_lists.id')
                ->get()->toArray();
        } else {
            $dishes = DB::table('dishes')
                ->leftJoin('dish_types', 'dish_types.id', '=', 'dishes.dish_type_id')
                ->Join('weekly_dish_lists', 'dishes.id', '=', 'weekly_dish_lists.dish_id')
                ->select('dishes.id', 'dishes.dish_type_id', 'dishes.order_type_id', 'dishes.name', 'weekly_dish_lists.day', 'dishes.price', 'dish_types.name as dish_type_name')
                ->where('weekly_dish_lists.day', '=', $day)
                ->where('dishes.order_type_id', '=', $orderTypeId)
                ->get()->toArray();
        }
        return $dishes;
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
