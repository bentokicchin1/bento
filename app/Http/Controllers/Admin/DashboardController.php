<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Order;
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
                  ->select("dish_types.name as dishType","dishes.name as dishName",DB::raw("count(*) as dishCount"))
                  ->join("order_items","orders.id","=","order_items.order_id")
                  ->join("dishes","order_items.dish_id","=","dishes.id")
                  ->join("dish_types","dishes.dish_type_id","=","dish_types.id")
                  ->where("orders.deleted_at", NULL)
                  ->where("orders.order_date",'2018-03-26')
                  ->groupBy("order_items.dish_id")
                  ->get();
        return view('admin.dashboard', ['orders' => $orders]);
    }
}
