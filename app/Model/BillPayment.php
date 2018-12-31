<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

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
    public static function sendGeneratedBills($user,$orders)
    {
        DB::beginTransaction();
        $billAmount = 0;
        foreach($orders as $key=>$order){
          if($order['status']=='ordered'){
            $billAmount += $order['total_amount'];
          }
        }
        $previousRec = DB::table('bill_payments')->order_by('payment_date', 'desc')->first();
        if(!empty($previousRec)){
            echo "<pre/>";
            print_r($previousRec);
            exit;
        }
        
        
        
//        $billObj = new BillPayment;
//        $billObj->user_id = $user['id'];
//        $billObj->month = date('m'.strtotime('this month'));
//        $billObj->outstanding_bill = $billAmount;
//        $billObj->total_bill = $billAmount;
//        $billObj->mode_of_payment = 'generated';
//        $billObj->save();
        DB::commit();
    }
}
