<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Customer;
use Validator;
use Exception;

class CustomerController extends Controller
{

    /**
     * Return customer dashboard.
     *
     * @return Response
     */
   
    public function dashboard(){
        return view('customer.dashboard');
    }

}
