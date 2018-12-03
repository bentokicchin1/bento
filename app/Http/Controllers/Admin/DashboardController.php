<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $list = array();
        $date = date('Y-m-d');
        $currentTime= date('h:i a');
        $orderTypeId = (strtotime($currentTime) > strtotime(config('constants.DASHBOARD_ORDER_MAX_TIME'))) ? 2 : 2;

        $orders = DB::table("orders")
                  ->select("dish_types.name as dishType","dishes.name as dishName",DB::raw("sum(order_items.quantity) as dishCount"))
                  ->join("order_items","orders.id","=","order_items.order_id")
                  ->join("dishes","order_items.dish_id","=","dishes.id")
                  ->join("dish_types","dishes.dish_type_id","=","dish_types.id")
                  ->where("orders.deleted_at", NULL)
                  ->where("orders.order_date",$date)
                  ->where("orders.order_type_id",$orderTypeId)
                  ->groupBy("order_items.dish_id")
                  ->get();

          $orderList = DB::select( DB::raw("SELECT u.id as userId,u.name as user,oi.quantity,d.name as dish,c.location as address,al.name as area, a.name as city,u.mobile_number
                        FROM `users` u
                        INNER JOIN customer_addresses c  ON c.user_id = u.id
                        LEFT JOIN area_locations al  ON c.sector = al.id
                        LEFT JOIN areas a  ON al.area_id = a.id
                        LEFT JOIN orders o  ON o.user_id = u.id
                        LEFT JOIN order_items oi  ON oi.order_id = o.id
                        INNER JOIN dishes d  ON oi.dish_id = d.id
                        WHERE o.order_date = :orderDate
                        AND o.order_type_id = :orderType
                        AND c.order_type_id = :orderTypeId"),
                        array(
                          'orderDate' => $date,
                          'orderType' => $orderTypeId,
                          'orderTypeId' => $orderTypeId
                        ));
        foreach ($orderList as $key => $value) {
          if(!array_key_exists($value->userId,$list)){
            $list[$value->userId] = array();
            $list[$value->userId]['name'] = $value->user;
            $list[$value->userId]['address'] = $value->address;
            $list[$value->userId]['mobile_number'] = $value->mobile_number;
            $list[$value->userId]['area'] = $value->area;
            $list[$value->userId]['city'] = $value->city;
            $list[$value->userId]['menu'] = '';
          }
          $list[$value->userId]['menu'] .= $value->quantity."*".$value->dish.", ";
        }
        return view('admin.dashboard', ['orders' => $orders,'orderList'=>$list]);
    }
}
