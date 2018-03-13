<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderType extends Model
{
    protected $dates = ['deleted_at'];

    public function weeklyMenu()
    {
        return $this->hasMany('App\Model\WeeklyDishList');
    }

    public function address()
    {
        return $this->hasMany('App\Model\CustomerAddresse');
    }
}
