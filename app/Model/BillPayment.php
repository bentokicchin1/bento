<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillPayment extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
    /*
    * function sendGeneratedBills
    * param $orders - Array of order details and cost of every order in previous month
    */
    // public static function sendGeneratedBills($user,$orders)
    // {
    //     foreach()
    // }
}
