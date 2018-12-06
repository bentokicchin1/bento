<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
      use SoftDeletes;
      protected $hidden = ["deleted_at"];
      
      
    public function feedback()
    {
        return $this->belongsTo('App\User');
    }
}
