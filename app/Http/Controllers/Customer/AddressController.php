<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderType;
use App\Services\Customer\AddressService;

class AddressController extends Controller
{

    private $addressService;

    public function __construct(AddressService $addressService){
        $this->addressService = $addressService;
    }

    public function showAddressForm(){

        /* fetch order type data based on order type */
        $orderTypes = OrderType::all('id','name')->pluck('name','id')
        ->map(function ($value, $key) {
            return ucfirst($value);
        })->all();
        
        return view('customer.address.add', ['orderTypes' => $orderTypes]);
    }


    public function saveAddress(Request $request){
        
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
        if($response == 'success'){
            return redirect()->route('address-add')->with('status', 'Address added successfully!');
        }
    }
}
