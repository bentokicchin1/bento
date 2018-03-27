<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    public function arealocation()
    {
        return $this->hasMany('App\Model\Area_location');
    }

    public function cityName()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function address()
    {
        return $this->hasMany('App\Model\CustomerAddresse');
    }
}
