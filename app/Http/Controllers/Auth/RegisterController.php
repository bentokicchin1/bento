<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Otp;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\BulkSmsService;

/* Used for Email Verification */
// use App\Model\VerifyUser;
// use App\Mail\VerifyMail;
// use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    private $smsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BulkSmsService $smsServ)
    {
        $this->smsService = $smsServ;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /* Generate OTP */
        $sixDigitOtp = mt_rand(100000, 999999);
        $smsServiceResponse = $this->smsService->sendOtp($data['mobile_number'], $sixDigitOtp);
        if($smsServiceResponse != 200){
            return redirect()->route('register')->withErrors('Something went wrong, Please try again later.');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'password' => bcrypt($data['password']),
        ]);

        /* Otp insert cade */
        $verifyUser = Otp::create([
            'user_id' => $user->id,
            'otp' => $sixDigitOtp,
        ]);

        /* Email Verification code */
        // $verifyUser = VerifyUser::create([
        //     'user_id' => $user->id,
        //     'token' => sha1(time()),
        // ]);

        // Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }

    public function showOtpForm()
    {
        return view('auth.verifyOtp');
    }

    /* Mobile Number Verification code */
    /* Validate Mobile Number */
    public function verifyOtp(Request $request)
    {
        $postOtp = $request->input('otp');
        $verifyOtp = Otp::where('otp', $postOtp)->first();
        if (isset($verifyOtp)) {
            $user = $verifyOtp->user;
            if (!$user->mobile_verified) {
                $verifyOtp->user->mobile_verified = 1;
                $verifyOtp->user->save();
                $status = "Your mobile number is verified. You can now login.";
            } else {
                $status = "Your mobile number is already verified. You can now login.";
            }
        } else {
            return redirect('/otp')->withErrors("Invalid OTP!!!");
        }

        return redirect('/login')->with('status', $status);
    }
}
