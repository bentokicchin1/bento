<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class CustomerController extends Controller
{

    /**
     * Return customer dashboard.
     *
     * @return Response
     */
   
    public function dashboard(Request $request){

        $userId = Auth::id();

        $userInfo = User::select('name', 'email', 'mobile_number')->where('id',$userId)->first()->toArray();
        
        $dashData['userInfo'] = $userInfo;

        return view('customer.dashboard', $dashData);
    }

}
