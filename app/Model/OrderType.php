<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderType extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];

    public function weeklyMenu()
    {
        return $this->hasMany('App\Model\WeeklyDishList');
    }

    public function address()
    {
        return $this->hasMany('App\Model\CustomerAddresse');
    }

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }
}
