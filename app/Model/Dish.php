<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dish extends Model
{
    //

    public function getDishListfromDb(){

        // $query = "Select dish.id, dish.dish_type_id, dish.order_type_id, dish.name, dish.price, dishType.name as dish_type_name 
        // FROM dishes as dish
        // LEFT JOIN dish_types as dishType ON (dish.dish_type_id = dishType.id)";

        // $dishes = DB::select($query);

        $dishes = DB::table('dishes')
            ->leftJoin('dish_types', 'dishes.dish_type_id', '=', 'dish_types.id')
            ->select('dishes.id', 'dishes.dish_type_id', 'dishes.order_type_id', 'dishes.name', 'dishes.price', 'dish_types.name as dish_type_name')
            ->get()->toArray();

        return $dishes;
    }
}
