<?php
namespace App\Http\Controllers\Transactions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use App\Services\PayuService;
use Tzsk\Payu\Facade\Payment;

class PayuController extends Controller
{
      // private $payuService;

      public function __construct()
      {
          // $this->payuService = $payuService;
      }

      public function showMakePaymentForm($amount=1)
      {
        $userDetailss = array();
        $userDetails['key'] = config('constants.PAYU_MERCHANT_KEY');
        $userDetails['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $userDetails['firstname'] = Auth::user()->name;
        $userDetails['email'] = Auth::user()->email;
        $userDetails['phone'] = Auth::user()->mobile_number;
        $userDetails['productinfo'] = 'Tiffin Bill';
        $userDetails['amount'] = $amount;
        // $payuDetails = $this->payuService->getPayuFormDetailsForUser(1393,$amount);
        return Payment::make($userDetails, function ($then) {

            // $then->redirectTo('payment/status');
            # OR...
            $then->redirectRoute('success');
            # OR...
            // $then->redirectAction('PaymentController@status');
        });
        // return view('transactions.makePayment', ['payuDetails'=>$payuDetails]);
      }


      public function handleSuccess()
      {
        $payment = Payment::capture();
      }

      public function handleFailure(Request $request)
      {
        echo "<pre/>";
        print_r($request);
        exit;
      }


}
