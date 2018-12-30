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
            foreach ($users->verification()->get() as $verification) {
               $verification->delete();
            }
            foreach ($users->subscriptions()->get() as $subscriptions) {
               $subscriptions->delete();
            }
            foreach ($users->feedbacks()->get() as $feedbacks) {
               $feedbacks->delete();
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

    public function verification()
    {
         return $this->hasMany('App\Model\VerifyUser');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Model\Subscription');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Model\Feedback','user_id');
    }

    public function payments()
    {
        return $this->hasMany('App\Model\BillPayment','user_id');
    }
}
