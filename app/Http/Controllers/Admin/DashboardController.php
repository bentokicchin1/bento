<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\DishType;
use App\Model\Dish;
use App\Model\OrderType;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        $date = date('Y-m-d');
        $orders = DB::table("orders")
                  ->select("dish_types.name as dishType","dishes.name as dishName",DB::raw("sum(order_items.quantity) as dishCount"))
                  ->join("order_items","orders.id","=","order_items.order_id")
                  ->join("dishes","order_items.dish_id","=","dishes.id")
                  ->join("dish_types","dishes.dish_type_id","=","dish_types.id")
                  ->where("orders.deleted_at", NULL)
                  ->where("orders.order_date",$date)
                  ->groupBy("order_items.dish_id")
                  ->get();


      $orderList = Order::with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                ->with('users')
                ->with('orderType')
                ->with('orderItems')
                ->where("orders.deleted_at", NULL)
                ->where("orders.order_date",$date)
                ->get()->toArray();

        return view('admin.dashboard', ['orders' => $orders,'orderList'=>$orderList]);
    }
}
