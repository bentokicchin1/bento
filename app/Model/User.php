<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

   public function address()
   {
       return $this->hasMany('App\Model\CustomerAddresse');
   }
}
