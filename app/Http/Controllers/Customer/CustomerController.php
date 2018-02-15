<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Services\Customer\CustomerService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $userInfo = User::select('name', 'email', 'mobile_number')->where('id', $userId)->first();
        $profileData['userInfo'] = $userInfo;
        return view('customer.profile', $profileData);
    }

    /**
     * Update updated user info into database table
     *
     * @return void
     */
    public function updateUserInfo(Request $request)
    {

        /* Retrieve post data */
        $postData = $request->only(['name', 'mobile_number']);
        /* Validate post data */
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|numeric|digits:10',
        ]);
        /* Save post data */
        $response = $this->customerService->updateUserInfo($postData);
        /* Return response */
        if ($response == 'success') {
            return redirect()->back()->with('status', 'Information updated successfully!');
        } else {
            return redirect()->back()->withErrors($response);
        }
    }

    public function changePassword(Request $request)
    {

        /* Retrieve post data */
        $postData = $request->all();
        /* Validate post data */
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        /* Verify entered old password is correct or not */
        if (!Hash::check($postData['current_password'], Auth::user()->password)) {
            return redirect()->back()->withErrors("Your current password does not matches with the password you provided. Please try again.");
        }

        /* Chack new password and current password are same or different */
        if (strcmp($postData['current_password'], $postData['new_password']) == 0) {
            return redirect()->back()->withErrors("New Password cannot be same as your current password. Please choose a different password.");
        }

        /* Save post data */
        $response = $this->customerService->changePassword($postData);
        /* Return response */
        if ($response == 'success') {
            return redirect()->back()->with('status', 'Information updated successfully!');
        } else {
            return redirect()->back()->withErrors($response);
        }

    }

}
