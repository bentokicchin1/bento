<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_type_id', 'quantity', 'total_amount', 'shipping_address', 'status'];


    /**
     * Fetch user orders list from db
     * 
     * @return array
     */
    public function getOrderListFromDb($userId)
    {
        $orders = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('order_types', 'orders.order_type_id', '=', 'order_types.id')
            ->select('orders.id', 'orders.total_amount', 'orders.status', 'orders.created_at', 'order_items.name', 'order_items.quantity', 'order_types.name as orderType')
            ->where('orders.user_id', '=', $userId)
            ->get()->toArray();
        return $orders;
    }

}
