<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
      use SoftDeletes;
      public $table = 'feedbacks';
      protected $hidden = ["deleted_at"];


    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
