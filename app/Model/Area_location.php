<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area_location extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    public function area()
    {
        return $this->belongsTo('App\Model\Area');
    }

    public function address()
    {
        return $this->hasMany('App\Model\CustomerAddresse');
    }
}
