<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\City;
use App\Model\Area_location;
use App\Model\Area;
use App\Model\OrderType;
use App\Model\CustomerAddresse;
use App\Services\Customer\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Display adderess form for add and edit case.
     *
     */
    public function showAddressForm($id = '', Request $request)
    {
        $data = [];
        $data['cityData'] = city::pluck('name', 'id');
        $data['orderTypeData'] = OrderType::pluck('name', 'id');
        $data['areaData'] = Area::pluck('name', 'id');
        $data['areaLocationData'] = Area_location::pluck('name', 'id');
        if (!empty($id)) {
            $data['addressData'] = $this->addressService->getAddressById($id);

        }
        /* fetch order type data based on order type */
        $data['orderTypes'] = OrderType::all('id', 'name')->pluck('name', 'id')
            ->map(function ($value, $key) {
                return ucfirst($value);
            })->all();

        /* If user coming from checkout page then store referer url to redirect after address save  */
        $refereUrl = $request->server('HTTP_REFERER');
        if (!empty($refereUrl)) {
            $request->session()->put('refererUrl', $refereUrl);
        }
        return view('customer.address.add', $data);
    }

    /**
     * Fetch list of addresses for customer
     *
     * @return array address list
     */
    public function index()
    {
        $addressList = $this->addressService->getAddressList();
        return view('customer.address.list', ['addressList' => $addressList]);
    }

    /**
     * Save addresses for customer based on address id
     *
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'order_type_id' => 'required|numeric',
            'location' => 'required',
            'name' => 'required',
            'area' => 'required',
            'sector' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|digits:6',
        ]);

        $userId = Auth::id();
        $existingRec = CustomerAddresse::where(['user_id'=>$userId,'order_type_id'=>$input['order_type_id']])->first();
        if(!empty($existingRec)){
            $input['id'] = $existingRec->id;
        }
        $response = $this->addressService->saveAddress($input);
        if ($response == 'success') {
            $request->session()->put('orderTypeId', $input['order_type_id']);
            if ($request->session()->has('refererUrl')) {
                $refereUrl = $request->session()->get('refererUrl');
                $request->session()->forget('refererUrl');
                return redirect($refereUrl)->with('status', 'Address saved successfully!');
            } else {
                return redirect()->back()->with('status', 'Address added successfully!');
            }
        } else {
            return redirect()->back()->withErrors('Something went wrong. Please try again.');
        }
    }

    /**
     * Soft delete addresses for customer based on address id
     *
     */
    public function delete($id, Request $request)
    {
        if (!empty($id)) {
            $this->addressService->deleteAddress($id);
            return redirect()->back()->with('status', 'Address deleted successfully!');
        }
    }
}
