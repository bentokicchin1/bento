<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    protected $table = 'city';
    public function areaName()
    {
        return $this->hasMany('App\Model\Area');
    }
}
