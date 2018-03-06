<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishType extends Model
{
    public function Dish()
    {
        return $this->hasMany('App\Model\Dish');
        //return $this->belongsTo('App\Model\Dish');
    }
}
