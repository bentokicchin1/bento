<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Model\OrderType;
use App\Services\Customer\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function showAddressForm($id='', Request $request)
    {
        $data = [];
        if(!empty($id)){
            $data['addressData'] = $this->addressService->getAddressById($id);
            
        }
        /* fetch order type data based on order type */
        $data['orderTypes'] = OrderType::all('id', 'name')->pluck('name', 'id')
            ->map(function ($value, $key) {
                return ucfirst($value);
            })->all();

        /* If user coming from checkout page then store referer url to redirect adter address save  */
        $refereUrl = $request->server('HTTP_REFERER');
        if (!empty($refereUrl)) {
            $request->session()->put('refererUrl', $refereUrl);
        }

        return view('customer.address.add', $data);
    }

    public function saveAddress(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'orderTypeId' => 'required|numeric',
            'addressTypes' => 'required',
            'location' => 'required',
            'name' => 'required',
            'area' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|digits:6',
            'city' => 'required',
        ]);

        $response = $this->addressService->saveAddress($input);
        if ($response == 'success') {
            if ($request->session()->has('refererUrl')) {
                $refereUrl = $request->session()->get('refererUrl');
                $request->session()->forget('refererUrl');
                return redirect($refereUrl)->with('status', 'Address added successfully!');
            } else {
                return redirect()->back()->with('status', 'Address added successfully!');
            }
        } else {
            return redirect()->back()->withErrors('Something went wrong. Please try again.');
        }
    }

    public function listAddress()
    {
        $addressList = $this->addressService->getAddressList();

        return view('customer.address.list', ['addressList' => $addressList]);
        // dd($addressList);
    }
}
