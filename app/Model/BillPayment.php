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
          $monthlyBillObj->invoice_id = $this->generateNewInvoiceId();
          $monthlyBillObj->bill_for_month = date('m',strtotime('first day of last month'));
          $monthlyBillObj->bill_for_year = date('Y');
          $monthlyBillObj->bill_date = date('Y-m-d');
          $monthlyBillObj->bill_amount = $billAmount;
          $monthlyBillObj->save();
        }
        $billObj = new BillPayment;
        $billObj->user_id = $user['id'];
        $billObj->payment_received = 0;
        $billObj->outstanding_bill = $billAmount + $pendingBill;
        $billObj->mode_of_payment = 'generated';
        $billObj->payment_date = date('Y-m-d');
        $billObj->save();
        DB::commit();
    }
    
    
    /*
    * function sendGeneratedBills
    * param $orders - Array of order details and cost of every order in previous month
    */
    public static function generateNewInvoiceId()
    {
        $record = MonthlyBills::latest()->first();
        $expNum = explode('-', $record->invoice_id);
        //check first day in a year
        if ( date('l',strtotime(date('Y-01-01'))) ){
            $nextInvoiceNumber = 'BTS'.date('Y').'-0001';
        } else {
            //increase 1 with last invoice number
            $nextInvoiceNumber = 'BTS'.$expNum[0].'-'. $expNum[1]+1;
        }
    }
}