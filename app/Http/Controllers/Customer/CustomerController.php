<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Services\Customer\CustomerService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    private $customerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Return customer dashboard.
     *
     * @return Response
     */

    public function dashboard(Request $request)
    {

        $userId = Auth::id();

        $userInfo = User::select('name', 'email', 'mobile_number')->where('id', $userId)->first()->toArray();

        $dashData['userInfo'] = $userInfo;

        return view('customer.dashboard', $dashData);
    }

    /**
     * Return customer order list
     *
     * @return Response
     */

    public function orders()
    {
        $userId = Auth::id();
        $orders = $this->customerService->fetchOrderList($userId);
        // dd($orders);
        return view('customer.orders', ['orders' => $orders]);
    }

    /**
     * Return customer profile
     *
     * @return Response
     */

    public function profile()
    {
        $userId = Auth::id();

        $userInfo = User::select('name', 'email', 'mobile_number')->where('id', $userId)->first()->toArray();

        $profileData['userInfo'] = $userInfo;

        return view('customer.profile', $profileData);
    }

}
