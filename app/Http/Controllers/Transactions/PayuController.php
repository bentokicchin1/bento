<?php

namespace App\Http\Controllers\Transactions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayuService;

class PayuController extends Controller
{
      private $payuService;

      public function __construct(PayuService $payuService)
      {
          $this->payuService = $payuService;
      }

      public function handleSuccess(Request $request)
      {
        echo "<pre/>";
        print_r($request);
        exit;
      }

      public function handleFailure(Request $request)
      {
        echo "<pre/>";
        print_r($request);
        exit;
      }

      public function showMakePaymentForm($amount)
      {
        $payuDetails = $this->payuService->getPayuFormDetailsForUser($amount);
        return view('transactions.makePayment', ['payuDetails'=>$payuDetails]);
      }

}
