<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\DishType;
use App\Model\Dish;
use App\Model\OrderType;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class DashboardController extends Controller
{
    public function index(){
        $list = array();
        $date = date('Y-m-d');
        $currentTime= date('h:i a');
        $orderTypeId = (strtotime($currentTime) > strtotime(config('constants.DASHBOARD_ORDER_MAX_TIME'))) ? 3 : 2;

        $orders = DB::table("orders")
                  ->select("dish_types.name as dishType","dishes.name as dishName",DB::raw("sum(order_items.quantity) as dishCount"))
                  ->join("order_items","orders.id","=","order_items.order_id")
                  ->join("dishes","order_items.dish_id","=","dishes.id")
                  ->join("dish_types","dishes.dish_type_id","=","dish_types.id")
                  ->where("orders.deleted_at", NULL)
                  ->where("orders.order_date",$date)
                  ->where("orders.status",'ordered')
                  ->where("orders.order_type_id",$orderTypeId)
                  ->groupBy("order_items.dish_id")
                  ->get();

          $orderList = DB::select( DB::raw("SELECT u.id as userId,u.name as user,o.total_amount as price,oi.quantity,d.name as dish,c.location as address,al.name as area, a.name as city,u.mobile_number
                        FROM `users` u
                        INNER JOIN customer_addresses c  ON c.user_id = u.id
                        LEFT JOIN area_locations al  ON c.sector = al.id
                        LEFT JOIN areas a  ON al.area_id = a.id
                        LEFT JOIN orders o  ON o.user_id = u.id
                        LEFT JOIN order_items oi  ON oi.order_id = o.id
                        LEFT JOIN dishes d  ON oi.dish_id = d.id
                        WHERE o.order_date = :orderDate
                        AND o.order_type_id = :orderType
                        AND c.order_type_id = :orderTypeId
                        AND o.status = 'ordered' AND o.deleted_at IS NULL
                        ORDER BY sector,city"),
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
            $list[$value->userId]['price'] = $value->price;
            $list[$value->userId]['menu'] = array();
          }
          array_push($list[$value->userId]['menu'],array('quantity'=>$value->quantity,'dish'=>$value->dish));
        }
        $user = Auth::user();
        Mail::to('skhilari26@gmail.com')->send(new OrderPlaced($user));
        
        return view('admin.dashboard', ['orders' => $orders,'orderList'=>$list]);
    }


    public function generatePDF()
    {
        $list = array();
        $date = date('Y-m-d');
        $currentTime= date('h:i a');
        $orderTypeId = (strtotime($currentTime) > strtotime(config('constants.DASHBOARD_ORDER_MAX_TIME'))) ? 3 : 2;

        $orderList = DB::select( DB::raw("SELECT u.id as userId,u.name as user,o.total_amount as price,oi.quantity,d.name as dish,c.location as address,al.name as area, a.name as city,u.mobile_number
                      FROM `users` u
                      INNER JOIN customer_addresses c  ON c.user_id = u.id
                      LEFT JOIN area_locations al  ON c.sector = al.id
                      LEFT JOIN areas a  ON al.area_id = a.id
                      LEFT JOIN orders o  ON o.user_id = u.id
                      LEFT JOIN order_items oi  ON oi.order_id = o.id
                      LEFT JOIN dishes d  ON oi.dish_id = d.id
                      WHERE o.order_date = :orderDate
                      AND o.order_type_id = :orderType
                      AND c.order_type_id = :orderTypeId
                      AND o.status = 'ordered' AND o.deleted_at IS NULL
                      ORDER BY sector,city"),
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
            $list[$value->userId]['price'] = $value->price;
            $list[$value->userId]['menu'] = array();
          }
          array_push($list[$value->userId]['menu'],array('quantity'=>$value->quantity,'dish'=>$value->dish));
        }
        $data = ['orderList' => $list];
        $pdf = PDF::loadView('exportOrders', $data);
        $date = date('Ymd');

        return $pdf->download('orders'.$date.'.pdf');

    }
}
