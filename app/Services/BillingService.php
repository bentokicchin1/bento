<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use App\Model\MonthlyBills;
use App\Model\BillPayment;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyBillGenerated;
use App\Services\BulkSmsService;

class BillingService extends App
{
    private $bulkSmsService;
    public function __construct(BulkSmsService $bulkSmsService)
    {
        $this->bulkSmsService = $bulkSmsService;
    }
    /*
    * function sendGeneratedBills
    * param $orders - Array of order details and cost of every order in previous month
    */
    public function sendGeneratedBills($user,$orders)
    {
        DB::beginTransaction();
        $notifyArray = $billDates = array();
        $billAmount = $pendingBill = 0;
        
        //Calculate total bill for last month
        foreach($orders as $key=>$order){
            if($order['status']=='ordered'){
                $billAmount += $order['total_amount'];
                array_push($billDates,date('d', strtotime($order['order_date'])));
            }
        }
        
        //Get latest pending bill for that User
        $previousRec = DB::table('bill_payments')->where('user_id', '1')->orderBy('payment_date', 'desc')->first();
        if(!empty($previousRec)){
            $pendingBill = $previousRec->outstanding_bill;
        }
        if(!empty($billAmount)){
            //Save data as monthly bill
            $monthlyBillObj = new MonthlyBills;
            $monthlyBillObj->user_id = $user['id'];
            $monthlyBillObj->invoice_id = $this->generateNewInvoiceId();
            $monthlyBillObj->bill_for_month = date('m',strtotime('first day of last month'));
            $monthlyBillObj->bill_for_year = date('Y');
            $monthlyBillObj->bill_date = date('Y-m-d');
            $monthlyBillObj->bill_amount = $billAmount;
            $monthlyBillObj->save();
        }
        //Save data as last pending bill 
        $billObj = new BillPayment;
        $billObj->user_id = $user['id'];
        $billObj->payment_received = 0;
        $billObj->outstanding_bill = $billAmount + $pendingBill;
        $billObj->mode_of_payment = 'generated';
        $billObj->payment_date = date('Y-m-d');
        $billObj->save();
        
        $notifyArray['user'] = $user;
        $notifyArray['orders'] = $orders;
        $notifyArray['billAmount'] = $billAmount;
        $notifyArray['pendingBill'] = $pendingBill;
        $notifyArray['outstanding_bill'] = $billAmount + $pendingBill;
        $notifyArray['billDates'] = $billDates;
        
        /// Send Invoice For Bills on Email
        Mail::to($user['email'])->cc('skhilari26@gmail.com')->send(new MonthlyBillGenerated($notifyArray));    
        
        /// Send short bill generated message on SMS
        $this->bulkSmsService->sendBillingSms($notifyArray);        
        DB::commit();
    }

    public function generateNewInvoiceId()
    {   
        $nextInvoiceNumber = '';
        $record = MonthlyBills::latest()->first();
        //check first day in a year
        if(!empty($record)){
            $expNum = explode('-', $record->invoice_id);
            if ( date('l',strtotime(date('Y-01-01'))) ){
                $nextInvoiceNumber = 'BTS'.date('Y').'-0001';
            } else {
                //increase 1 with last invoice number
                $nextInvoiceNumber = 'BTS'.$expNum[0].'-'. $expNum[1]+1;
            }
        }else{
            $nextInvoiceNumber = 'BTS'.date('Y').'-0001';
        }
        return $nextInvoiceNumber;
    }

}
