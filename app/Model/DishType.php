<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishType extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    public function Dish()
    {
        return $this->hasMany('App\Model\Dish');
        //return $this->belongsTo('App\Model\Dish');
    }
}
