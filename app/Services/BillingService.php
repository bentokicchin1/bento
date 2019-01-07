<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use App\Model\MonthlyBills;

class BillingService extends App
{
    public function __construct()
    {
        
    }
    /*
    * function sendGeneratedBills
    * param $orders - Array of order details and cost of every order in previous month
    */
    public function sendGeneratedBills($user,$orders)
    {
        DB::beginTransaction();
        $invoiceId = $this->generateNewInvoiceId();
        echo "<pre/>";
        print_R($invoiceId);
        exit;
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
            $monthlyBillObj->invoice_id = $invoiceId;
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

    public function generateNewInvoiceId()
    {   
        $nextInvoiceNumber = '';
        $record = MonthlyBills::latest()->first();
        $expNum = explode('-', $record->invoice_id);
        //check first day in a year
        if ( date('l',strtotime(date('Y-01-01'))) ){
            $nextInvoiceNumber = 'BTS'.date('Y').'-0001';
        } else {
            //increase 1 with last invoice number
            $nextInvoiceNumber = 'BTS'.$expNum[0].'-'. $expNum[1]+1;
        }
        return $nextInvoiceNumber;
    }

}
