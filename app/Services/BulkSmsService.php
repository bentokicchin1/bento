<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class BulkSmsService extends App
{

    private $username;
    private $password;
    private $mobileNumber;
    private $sender;
    private $message;
    private $url;

    public function __construct()
    {
        $this->username = config('constants.BULK_SMS_USERNAME');
        $this->password = config('constants.BULK_SMS_PASSWORD');
        $this->url = config('constants.BULK_SMS_URL');
        $this->sender = config('constants.BULK_SMS_SENDER');
    }

    public function sendOtp($mobileNumber, $otp)
    {
        $this->mobileNumber = $mobileNumber;
        $this->message = "Thank you for registration. Your OTP is " . $otp;
        
        $this->sendSms();
//        try{
//          //Don't change below code use as it is
//          $bulkSmsCurlUrl = $this->url . "?user=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&mobile=" . urlencode($this->mobileNumber) . "&message=" . urlencode($this->message) . "&sender=" . urlencode($this->sender) . "&type=" . urlencode('3');
//          $client = new Client(); //GuzzleHttp\Client
//          $result = $client->get($bulkSmsCurlUrl);
//          return $result->getStatusCode();    // 200
//        } catch (Exception $e) {
//            DB::rollBack();
//            return redirect()->back()->withErrors('Something went wrong. Please try again.');
//        }
    }
    
    

    public function sendBillingSms($notifyArray)
    {
        $this->mobileNumber = $notifyArray['user']['mobile_number'];
        $month = date('F Y',strtotime('first day of last month'));
        $this->message = "Hi,
                Total tiffins count of $month = ".count($notifyArray['billDates'])."
                Tiffins On Dates ".implode(",",$notifyArray['billDates'])."
                Previous unbilled amount = ".$notifyArray['pendingBill']."
                Current unbilled amount = ".$notifyArray['billAmount']."
                Total unbilled amount = ".$notifyArray['outstanding_bill']."

                Thanks,
                Bento";
        $this->sendSms();
    }
    
    public function sendSms()
    {
        try{
          //Don't change below code use as it is
          $billingSmsUrl = $this->url . "?user=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&mobile=" . urlencode($this->mobileNumber) . "&message=" . urlencode($this->message) . "&sender=" . urlencode($this->sender) . "&type=" . urlencode('3');
          $client = new Client(); //GuzzleHttp\Client
          $result = $client->get($billingSmsUrl);
          return $result->getStatusCode();    // 200
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Something went wrong. Please try again.');
        }
    }

}
