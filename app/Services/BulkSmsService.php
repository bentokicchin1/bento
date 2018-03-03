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

        //Don't change below code use as it is
        $bulkSmsCurlUrl = $this->url . "?user=" . urlencode($this->username) . "&password=" . urlencode($this->password) . "&mobile=" . urlencode($this->mobileNumber) . "&message=" . urlencode($this->message) . "&sender=" . urlencode($this->sender) . "&type=" . urlencode('3');

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get($bulkSmsCurlUrl);
        return $result->getStatusCode();    // 200
    }

}
