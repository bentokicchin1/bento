<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    protected static function boot()
    {
       parent::boot();
       static::deleting(function($users) {
         foreach ($users->orders()->get() as $orders) {
            $orders->delete();
         }
         foreach ($users->address()->get() as $address) {
            $address->delete();
         }
       });
    }
    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

   public function address()
   {
       return $this->hasMany('App\Model\CustomerAddresse');
   }
}
