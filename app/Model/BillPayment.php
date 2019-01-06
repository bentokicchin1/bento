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
        $billAmount = $pendingBill = 0;
        foreach($orders as $key=>$order){
          if($order['status']=='ordered'){
            $billAmount += $order['total_amount'];
          }
        }
        $previousRec = DB::table('bill_payments')->where('user_id', '1')->orderBy('payment_date', 'desc')->first();
        if(!empty($previousRec)){
          $pendingBill = $previousRec->outstanding_bill;
        }

        if(!empty($billAmount)){
          $monthlyBillObj = new MonthlyBills;
          $monthlyBillObj->user_id = $user['id'];
          $monthlyBillObj->bill_for_month = date('m'.strtotime('last month'));
          $monthlyBillObj->bill_for_year = date('Y');
          $monthlyBillObj->bill_date = date('Y-m-d');
          $monthlyBillObj->bill_amount = $billAmount;
        }
        $billObj = new BillPayment;
        $billObj->user_id = $user['id'];
        $billObj->payment_received = 0;
        $billObj->outstanding_bill = $billAmount + $pendingBill;
        $billObj->mode_of_payment = 'generated';
        $billObj->save();
        DB::commit();
    }
}
