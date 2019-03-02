<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PayuService extends App
{
    private $payukey;
    private $payusalt;
    private $payubaseurl;
    private $payuauthheader;

    public function __construct()
    {
        $this->payukey = config('constants.PAYU_MERCHANT_KEY');
        $this->payusalt = config('constants.PAYU_MERCHANT_SALT');
        $this->payubaseurl = config('constants.PAYU_SANDBOX_BASE_URL');
        $this->payusequence = config('constants.PAYU_SENDING_HASH_SEQUENCE');
    }
    /*
    * function getPayuFormDetails
    * param $orders - Array of order details and cost of every order in previous month
    */
    public function getPayuFormDetailsForUser($amount)
    {
        $hash_string = '';
        $hashVarsSeq = explode('|', $this->payusequence);
        $userDetails = array();
        if (!empty(Auth::id())) {
            $userId = Auth::id();
            $userDetails['key'] = $this->payukey;
            $userDetails['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $userDetails['firstname'] = Auth::user()->name;
            $userDetails['email'] = Auth::user()->email;
            $userDetails['phone'] = Auth::user()->mobile_number;
            $userDetails['productinfo'] = 'Tiffin Bill';
            $userDetails['amount'] = $amount;
            $userDetails['phone'] = Auth::user()->mobile_number;
            $userDetails['service_provider'] = 'payu_paisa';
            $userDetails['surl'] = route('success');
            $userDetails['furl'] = route('failure');

            if(!empty($userDetails)) {
              if(empty($userDetails['key']) || empty($userDetails['txnid']) || empty($userDetails['amount']) || empty($userDetails['firstname']) || empty($userDetails['email']) || empty($userDetails['phone']) || empty($userDetails['productinfo']) || empty($userDetails['surl']) || empty($userDetails['furl']) || empty($userDetails['service_provider'])) {
                 $userDetails['formError'] = 1;
                 $userDetails['action'] = $this->payubaseurl . '/_payment';
              } else {
            	    foreach($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($userDetails[$hash_var]) ? $userDetails[$hash_var] : '';
                    $hash_string .= '|';
                  }
                  $hash_string .= $this->payusalt;
                  $userDetails['hash'] = strtolower(hash('sha512', $hash_string));
                  $userDetails['action'] = $this->payubaseurl . '/_payment';
              }
            }
            return $userDetails;
        }else{
            return redirect()->back()->withErrors("Please login..");
        }
    }

}
