<?php

namespace App\Model;

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
}
