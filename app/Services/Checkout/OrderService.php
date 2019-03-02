<?php

/**
 * Service for order related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Checkout;

use DB;
use App\Model\Dish;
use App\Model\DishType;
use App\Model\Order;
use App\Model\User;
use App\Model\OrderItem;
use App\Model\WeeklyDishList;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class OrderService
{

    private $dishes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Dish $dishes, Order $order)
    {
        $this->dishes = $dishes;
    }

    public function getSingleOrderDetails($orderId)
    {
        $orderItems = $ordersData = array();
        $ordersData = Order::with('users')
                   ->with('orderType')
                   ->with('orderItems.orderDish')
                   ->where("orders.deleted_at", NULL)
                   ->where('id',$orderId)->first()->toArray();

        $orderItems = $this->formatOrderItems($ordersData);
        if(!empty($ordersData)){
            $orderItems['users'] = $ordersData['users'];
            $orderItems['id'] = $ordersData['id'];
            $orderItems['order_type_id'] = $ordersData['order_type_id'];
            $orderItems['order_date'] = $ordersData['order_date'];
            $orderItems['order_type'] = $ordersData['order_type'];
            $orderItems['status'] = $ordersData['status'];
            $orderItems['total_amount'] = $ordersData['total_amount'];
        }
        return $orderItems;
    }


    public function getDishList($orderTypeId,$orderDate='')
    {
        /* TODO - Add proper day function to get data from DB. Below MONDAY is hard coded */
        $orderDate = ($orderDate=='') ? 'all' : date('Y-m-d',strtotime($orderDate));
        $rawDishList = $this->dishes->getDishListfromDb($orderTypeId,$orderDate);
        return $this->formatDishList($rawDishList);
    }

    public function formatDishList($rawDishList)
    {

        $sortedData = [];
        foreach ($rawDishList as $key => $dishItem) {
            $sortedData[$dishItem->dish_type_id]['dishTypeId'] = $dishItem->dish_type_id;
            $sortedData[$dishItem->dish_type_id]['dishTypeName'] = strtolower(str_replace(' ', '_', $dishItem->dish_type_name));
            $sortedData[$dishItem->dish_type_id]['dishList'][$dishItem->id] = ucfirst($dishItem->name);
            $sortedData[$dishItem->dish_type_id]['dishPrice'][$dishItem->id] = $dishItem->price;
        }
        return array_values($sortedData);
    }


    /**
     * Process order form data.
     * @param (array)postData
     * @return void
     */
    public function processSubscriptionData($orderData)
    {
        $orderParams['quantity'] = 1;
        $orderParams['order_date'] = isset($orderData['orderDate']) ? date('Y-m-d',strtotime($orderData['orderDate'])) : date('Y-m-d');
        $orderParams['orderTypeId'] = $orderData['orderTypeId'];
        $orderParams['quantity'] = 1;
        $orderParams['user_id'] = isset($orderData['user']) ? $orderData['user'] : Auth::id();
        $orderParams['shippingAddressId'] = $orderData['shippingAddressId'];
        $orderParams['status'] = 'ordered';
        $orderParams['orderTotalAmount'] = $orderData['orderTotalAmount'];
        $orderParams['items'] = $orderData['items'];
        return $this->insertOrder($orderParams);
    }

    /**
     * Process order form data.
     * @param (array)postData
     * @return void
     */
    public function processData($addressId)
    {
        $orderData = session('orderData');

        if(!empty($orderData['id'])){
          $orderParams['id'] = $orderData['id'];
        }
        $orderParams['quantity'] = 1;
        $orderParams['order_date'] = isset($orderData['orderDate']) ? date('Y-m-d',strtotime($orderData['orderDate'])) : date('Y-m-d');
        $orderParams['orderTypeId'] = $orderData['orderTypeId'];
        $orderParams['quantity'] = 1;
        $orderParams['user_id'] = isset($orderData['user']) ? $orderData['user'] : Auth::id();
        $orderParams['shippingAddressId'] = $addressId;
        $orderParams['status'] = 'ordered';
        $orderParams['orderTotalAmount'] = $orderData['orderTotalAmount'];
        $orderParams['items'] = $orderData['items'];

        return $this->insertOrder($orderParams);

    }

    public function rearrangeOrderPostData($postData)
    {

        $response = [];
        /* Created array of all dish type we have in db and formatting them in lowercase and replacing space with underscore */
        $dishTypes = DishType::all('name')->pluck('name')
            ->map(function ($value, $key) {
                return strtolower(str_replace(' ', '_', $value));
            })->all();

        $orderTypeId = $postData['orderTypeId'];
        unset($postData['orderTypeId'], $postData['_token']);

        $response = $this->createFinalDetailedItemList($dishTypes, $postData);
        $response['orderTypeId'] = $orderTypeId;
        return $response;
    }

    public function createFinalDetailedItemList($dishTypes, $postData)
    {
        $response = [];
        $item = [];
        $orderTotalAmount = 0;
        /* Looping through each dish type and checking which are sent over post data  */
        foreach ($dishTypes as $dishTypeName) {
            /* If post data contains dish type then create new array with 'dish_id' and 'quantity' */
            if (array_key_exists($dishTypeName, $postData) && $dishTypeName != 'others') {
                /* If value is not selected from drop down or quantity is empty then do not add those in response node */
                if (!empty($postData[$dishTypeName]) && !empty($postData['qty_' . $dishTypeName])) {

                    $dishId = $postData[$dishTypeName];

                    $dishDetail = $this->dishes->getDishDetailById($dishId);
                    $item[$dishTypeName]['dish_id'] = $dishId;
                    $item[$dishTypeName]['qty'] = $postData['qty_' . $dishTypeName];
                    $item[$dishTypeName]['name'] = $dishDetail->name;
                    $item[$dishTypeName]['base_price'] = $dishDetail->price;
                    $item[$dishTypeName]['total_price'] = $dishDetail->price * $postData['qty_' . $dishTypeName];

                    $orderTotalAmount += $dishDetail->price * $postData['qty_' . $dishTypeName];
                }
                /* Unsetting items so that at the end of loop we will have only "others" type of dishes in "postdata" node */
                unset($postData[$dishTypeName], $postData['qty_' . $dishTypeName], $dishDetail);
            }
        }

        /* If post data contains other type of dishes then push them to item node */
        if (!empty($postData)) {
            $i = 0;
            foreach ($postData as $key => $dishId) {
              if(strpos($key, 'others')  !== false){
                $dishDetail = $this->dishes->getDishDetailById($dishId);
                $item['others'][$i]['dish_id'] = $dishId;
                $item['others'][$i]['qty'] = 1;
                $item['others'][$i]['name'] = $dishDetail->name;
                $item['others'][$i]['base_price'] = $dishDetail->price;
                $item['others'][$i]['total_price'] = $dishDetail->price;
                $orderTotalAmount += $dishDetail->price;
                $i++;
              }
            }
        }
        $response = $postData;
        $response['orderTotalAmount'] = $orderTotalAmount;
        $response['items'] = $item;

        return $response;
    }

    /**
     * Insert Order in table
     */
    private function insertOrder($orderParams)
    {
        DB::beginTransaction();
        try {
            if (!empty($orderParams['id'])) {
                $order = Order::find($orderParams['id']);
            } else {
                $order = new Order;
            }
            $order->user_id = $orderParams['user_id'];
            $order->order_type_id = $orderParams['orderTypeId'];
            $order->quantity = $orderParams['quantity'];
            $order->total_amount = $orderParams['orderTotalAmount'];
            $order->shipping_address_id = $orderParams['shippingAddressId'];
            $order->order_date = $orderParams['order_date'];
            $order->status = $orderParams['status'];
            $order->save();

            $orderId = $order->id;
            $this->insertOrderItems($orderId, $orderParams['items']);

            $user = User::find($order->user_id);
            $userEmail = $user->email;
            $orders = $this->getSingleOrderDetails($orderId);
            Mail::to($userEmail)->send(new OrderPlaced($orders));
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }
    }

    /**
     * Insert Order item in table
     */
    private function insertOrderItems($orderId, $items)
    {
        try {
            DB::table('order_items')->where('order_id',$orderId)->delete();
            if (!empty($items)) {
                foreach ($items as $key => $item) {
                    if ($key != 'others') {
                        $itemParams[] = ['order_id' => $orderId, 'dish_id' => $item['dish_id'], 'quantity' => $item['qty'], 'base_price' => $item['base_price'], 'total_price' => $item['total_price']];
                    } else {
                        foreach ($item as $otherItem) {
                            $itemParams[] = ['order_id' => $orderId, 'dish_id' => $otherItem['dish_id'], 'quantity' => $otherItem['qty'], 'base_price' => $otherItem['base_price'], 'total_price' => $otherItem['total_price']];
                        }
                    }
                }

                OrderItem::insert($itemParams);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function validateOrderFormData($postData)
    {
        $message = 'success';
        if (!empty($postData)) {
            if ((int) $postData['orderTotalAmount'] < 45) {
                $message = 'Total amount should be greater than Rs. 45';
            }
        }
        return $message;
    }

    public function checkBillingCycle(){
        $user_id = Auth::id();
        return User::where(['id'=>$user_id,'billing_cycle'=>null])->first();
    }

    public function formatOrderItems($orderItems){
      $finalList['orderDishes'] = array();
      if(!empty($orderItems['order_items'])){
        foreach ($orderItems['order_items'] as $key => $item) {
            $dishId = $item['order_dish']['id'];
            $dish['dishId'] = $dishId;
            $dish['dishTypeId'] = $item['order_dish']['dish_type_id'];
            $dish['dishName'] = $item['order_dish']['name'];
            $dish['dishPrice'] = $item['base_price'];
            $dish['totalPrice'] = $item['total_price'];
            $dish['quantity'] = $item['quantity'];
            if($item['order_dish']['dish_type_id']!=config('constants.DISH_TYPE_OTHER')){
              $finalList['orderDishes'][$item['order_dish']['dish_type_id']] = $dish;
            }else{
              $finalList['orderDishes'][$item['order_dish']['dish_type_id']][$dishId] = $dish;
            }
        }
      }
      return $finalList;
    }

    public function getDishListForAdmin($orderTypeId,$orderDate)
    {
        /* TODO - Add proper day function to get data from DB. Below MONDAY is hard coded */
        $orderDate = date('Y-m-d',strtotime($orderDate));
        $rawDishList = $this->dishes->getDishListfromDbForAdmin($orderTypeId,$orderDate);
        return $this->formatDishList($rawDishList);
    }
}
