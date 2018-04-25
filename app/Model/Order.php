<?php

namespace App\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Order extends Model
{
    use SoftDeletes;
    protected $hidden = ["deleted_at"];
    protected static function boot()
    {
       parent::boot();
       static::deleting(function($users) {
         foreach ($users->orderItems()->get() as $orderItems) {
            $orderItems->delete();
         }
       });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_type_id', 'quantity', 'total_amount', 'shipping_address', 'status'];

    /**
     * Get the order items associated with the order.
     */
    public function orderItems()
    {
        return $this->hasMany('App\Model\OrderItem');
    }

    public function users()
    {
       return $this->belongsTo('App\Model\User','user_id');
    }

     public function shipping_address()
     {
         return $this->belongsTo('App\Model\CustomerAddresse','shipping_address_id');
     }

     public function orderType()
     {
        return $this->belongsTo('App\Model\OrderType');
     }

    public static function getOrderDetails($id)
    {
        $orderList = array();
        $orders = DB::table('orders')
              ->select("orders.id as order_id", "dishes.name as dishName", "order_types.id as order_type_id", "order_types.name as orderTypeName","order_items.quantity","order_items.base_price","orders.total_amount","orders.status","orders.created_at")
              ->join("order_items","orders.id","=","order_items.order_id")
              ->join("order_types","orders.order_type_id","=","order_types.id")
              ->join("dishes","order_items.dish_id","=","dishes.id")
              ->where('orders.deleted_at', NULL)
              ->where('user_id', $id)
              ->get();

              $i = 0;
        foreach($orders as $order){
          if(!array_key_exists($order->order_id,$orderList)){
            $i++;
            $orderList[$order->order_id]['dishList'] = array();
            $orderList[$order->order_id]['id'] = $order->order_id;
            $orderList[$order->order_id]['total_amount'] = $order->total_amount;
            $orderList[$order->order_id]['status'] = $order->status;
            $orderList[$order->order_id]['created_at'] =  $order->created_at;
            $orderList[$order->order_id]['orderTypeName'] =  $order->orderTypeName;
            $orderList[$order->order_id]['orderTypeId'] =  $order->order_type_id;
            array_push($orderList[$order->order_id]['dishList'],array('dishName'=>$order->dishName,'quantity'=>$order->quantity,'base_price'=>$order->base_price));
          }else{
            array_push($orderList[$order->order_id]['dishList'],array('dishName'=>$order->dishName,'quantity'=>$order->quantity,'base_price'=>$order->base_price));
          }
        }
        $orderList['total'] = $i;
        return $orderList;
    }
}
