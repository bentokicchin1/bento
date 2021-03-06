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
        $cityData = city::pluck('name', 'id');
        $orderTypeData = OrderType::pluck('name', 'id');
        $areaData = Area::pluck('name', 'id');
        $areaLocationData = Area_location::pluck('name', 'id');
        if (!empty($id)) {
            $usersData = DB::table('users')
                  ->select("users.id as id","users.name as name", "email","mobile_number","billing_cycle","food_preference","tiffin_quantity","mobile_verified","customer_addresses.order_type_id","customer_addresses.location","customer_addresses.sector","customer_addresses.area","customer_addresses.city","customer_addresses.state","customer_addresses.pincode")
                  ->leftJoin("customer_addresses","customer_addresses.user_id","=","users.id")
                  ->where('users.id',$id)
                  ->where('users.deleted_at',null)
                  ->first();
        }
        return view('admin.users.userAdd', ['usersData' => $usersData,'cityData'=>$cityData,'orderTypeData'=>$orderTypeData,'areaData'=>$areaData,'areaLocationData'=>$areaLocationData]);
    }

    public function index()
    {
        $users = DB::table('users')
              ->select("users.id as id","users.name as name", "email","mobile_number","billing_cycle","food_preference","tiffin_quantity","mobile_verified","customer_addresses.order_type_id","customer_addresses.location","area_locations.name as sector","customer_addresses.area","customer_addresses.city","customer_addresses.state","customer_addresses.pincode")
              ->leftJoin("customer_addresses","customer_addresses.user_id","=","users.id")
              ->leftJoin("area_locations","customer_addresses.sector","=","area_locations.id")
              ->where('users.deleted_at',null)->get();
        return view('admin.users.userList', ['user' => $users]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'name' => 'required',
            'order_type_id' => 'required|numeric',
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
                if(empty($addressObj)){
                  $addressObj = new CustomerAddresse;
                }
            } else {
                $userObj = new user;
                $addressObj = new CustomerAddresse;
            }
            $userObj->name = $request->input('name');
            $userObj->password = bcrypt('bento@123');
            $userObj->mobile_number = $request->input('mobile_number');
            $userObj->mobile_verified = ($request->input('mobile_verified')!=null) ? $request->input('mobile_verified') : false;
            $userObj->billing_cycle = $request->input('billing_cycle');
            $userObj->food_preference = $request->input('food_preference');
            $userObj->tiffin_quantity = $request->input('tiffin_quantity');
            $userObj->save();
            $userId = $userObj->id;

            $addressObj->user_id = $userId;
            $addressObj->order_type_id = $request->input('order_type_id');
            $addressObj->name = $request->input('name');
            $addressObj->location = $request->input('location');
            $addressObj->area = $request->input('area');
            $addressObj->sector = $request->input('sector');
            $addressObj->city = $request->input('city');
            $addressObj->state = $request->input('state');
            $addressObj->pincode = $request->input('pincode');
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
        $orders = Order::where('user_id',$id)
                  ->with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                  ->with('users')
                  ->with('orderType')
                  ->where('orders.deleted_at',null)
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
                $user->delete();
                return redirect()->back()->with('status', 'User deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
