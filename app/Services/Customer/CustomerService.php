<?php

/**
 * Service for address related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Customer;

use App\Model\Order;
use Illuminate\Support\Facades\Auth;

class CustomerService
{

    private $order;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Fetch user orders list from db
     *
     * @return array
     */
    public function fetchOrderList($userId)
    {
        $orders = [];
        if (!empty($userId)) {
            $orders = $this->order->getOrderListFromDb($userId);
            if (!empty($orders)) {
                $orders = $this->reArrangeOrderList($orders);
            }
        }
        return $orders;
    }

    /**
     * Re arrange fetched order list items
     *
     * @return array
     */
    public function reArrangeOrderList($orders)
    {
        $sortedOrders = [];
        foreach ($orders as $orderData) {
            $sortedOrders[$orderData->id]['orderId'] = $orderData->id;
            $sortedOrders[$orderData->id]['date'] = $orderData->created_at;
            $sortedOrders[$orderData->id]['amount'] = $orderData->total_amount;
            $sortedOrders[$orderData->id]['orderType'] = $orderData->orderType;
            $sortedOrders[$orderData->id]['status'] = $orderData->status;
            $sortedOrders[$orderData->id]['items'][] = $orderData->name . ' x ' . $orderData->quantity;
        }
        return $sortedOrders;
    }

}
