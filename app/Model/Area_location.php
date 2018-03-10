<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area_location extends Model
{
    public function area()
    {
        return $this->belongsTo('App\Model\Area');
    }
}
