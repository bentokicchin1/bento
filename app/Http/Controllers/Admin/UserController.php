<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\City;
use App\Model\Area_location;
use App\Model\Area;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\OrderType;
use App\Model\CustomerAddresse;
use App\Services\Customer\AddressService;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{

      private $addressService;

      public function __construct(AddressService $addressService)
      {
          $this->addressService = $addressService;
      }


    public function showForm($id = '', Request $request)
    {
        $usersData = [];
        $userTypeData = config('constants.USER_TYPE');
        $addressTypeData = config('constants.ADDRESS_TYPE');
        $cityData = city::pluck('name', 'id');
        $orderTypeData = OrderType::pluck('name', 'id');
        $areaData = Area::pluck('name', 'id');
        $areaLocationData = Area_location::pluck('name', 'id');
        if (!empty($id)) {
            $usersData = DB::table('users')
                  ->select("users.id as id","users.name as name", "email","mobile_number","user_type","billing_cycle","mobile_verified","customer_addresses.order_type_id","customer_addresses.address_type","customer_addresses.location","customer_addresses.sector","customer_addresses.area","customer_addresses.city","customer_addresses.state","customer_addresses.pincode")
                  ->join("customer_addresses","customer_addresses.user_id","=","users.id")
                  ->where('users.id',$id)
                  ->first();
        }
        return view('admin.users.userAdd', ['usersData' => $usersData,'userTypeData'=>$userTypeData,'addressTypeData'=>$addressTypeData,'cityData'=>$cityData,'orderTypeData'=>$orderTypeData,'areaData'=>$areaData,'areaLocationData'=>$areaLocationData]);
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.userList', ['user' => $users]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'name' => 'required',
            'user_type' => 'required',
            'mobile_number' => 'required|digits:10',
            'order_type_id' => 'required|numeric',
            'address_type' => 'required',
            'location' => 'required',
            'area' => 'required',
            'sector' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|digits:6'
        ]);
        DB::beginTransaction();
        $id = $request->input('id');
        try {
            if (!empty($id)) {
                $userObj = user::find($id);
                $addressObj = CustomerAddresse::where('user_id',$id)->first();
            } else {
                $userObj = new user;
                $addressObj = new CustomerAddresse;
            }
            $userObj->name = $request->input('name');
            $userObj->user_type = $request->input('user_type');
            $userObj->password = bcrypt('123456');
            $userObj->mobile_number = $request->input('mobile_number');
            $userObj->mobile_verified = ($request->input('mobile_verified')!=null) ? $request->input('mobile_verified') : false;
            $userObj->billing_cycle = $request->input('billing_cycle');
            $userObj->save();
            $userId = $userObj->id;


            $addressObj->user_id = $userId;
            $addressObj->order_type_id = $request->input('order_type_id');
            $addressObj->address_type = $request->input('address_type');
            $addressObj->name = $request->input('name');
            $addressObj->location = $request->input('location');
            $addressObj->area = $request->input('area');
            $addressObj->sector = $request->input('sector');
            $addressObj->city = $request->input('city');
            $addressObj->state = $request->input('state');
            $addressObj->pincode = $request->input('pincode');
            $addressObj->default = $request->input('default') ?? 0;
            $addressObj->save();
            DB::commit();

            return redirect()->route('admin-user-list')->with('status', 'User added successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Something went wrong. Please try again.');
        }
    }

    public function order($id)
    {
      DB::enableQueryLog();
        $orders = Order::where('user_id',$id)
                  ->with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                  ->with('users')
                  ->with('orderType')
                  ->get();
        return view('admin.orders.orderList', ['orders' => $orders]);
    }

    /**
     * Soft delete order type
     *
     */
    public function delete($id, Request $request)
    {
        if (!empty($id)) {
            try {
                $user = User::find($id);
                // $user->orders()->orderItems('id')->delete();
                // $user->orders()->delete();
                // $user->address()->delete();
                $user->delete();
                return redirect()->back()->with('status', 'Dish type deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
