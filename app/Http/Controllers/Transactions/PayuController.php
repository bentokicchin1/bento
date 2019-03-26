<?php
namespace App\Http\Controllers\Transactions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Services\PayuService;
use Tzsk\Payu\Facade\Payment;
use App\Model\BillPayment;
use DB;

class PayuController extends Controller
{
      // private $payuService;

      public function __construct()
      {
          // $this->payuService = $payuService;
      }

      public function showMakePaymentForm($amount=1)
      {
        $userDetails = array();
        $userDetails['key'] = config('constants.PAYU_MERCHANT_KEY');
        $userDetails['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $userId = Auth::user()->id;
        $userDetails['firstname'] = Auth::user()->name;
        $userDetails['email'] = Auth::user()->email;
        $userDetails['phone'] = Auth::user()->mobile_number;
        $userDetails['productinfo'] = 'Tiffin Bill';
        $billData = DB::table('bill_payments')->where('user_id', $userId)->orderBy('updated_at', 'desc')->first();
        $userDetails['amount'] = $billData->outstanding_bill;
        $userDetails['udf1'] = $userId;
        echo "<pre/>";
        print_R($userDetails);
        exit;
//        $userDetails['udf1'] = $orderId;
        return Payment::make($userDetails, function ($then) {
            $then->redirectRoute('success');
        });
      }


      public function handleSuccess()
      {
        $payment = Payment::capture();
        echo "<pre/>";
        print_r($payment);
        exit;
      }

      public function handleFailure(Request $request)
      {
        echo "<pre/>";
        print_r($request);
        exit;
      }


}
