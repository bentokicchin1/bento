<?php

/**
 * Service for subscription related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Checkout;

use DB;
use App\Model\Dish;
use App\Model\DishType;
use App\Model\Order;
use App\Model\Subscription;
use App\Services\Checkout\OrderService;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{

    private $dishes;
    private $orderService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Dish $dishes, Order $order, OrderService $orderService)
    {
        $this->dishes = $dishes;
        $this->orderService = $orderService;
    }

    public function getDishList($orderTypeId)
    {
        $rawDishList = $this->dishes->getDishListfromDb($orderTypeId, 'all');
        return $this->formatDishList($rawDishList);
    }

    /* Re-arrange dish raw data based on day and dish type  */
    public function formatDishList($rawDishList)
    {
        $sortedData = [];
        $finalData = [];
        if(!empty($rawDishList)){
            foreach ($rawDishList as $key => $dishItem) {
                $sortedData[$dishItem->day][$dishItem->dish_type_id]['dishTypeId'] = $dishItem->dish_type_id;
                $sortedData[$dishItem->day][$dishItem->dish_type_id]['dishTypeName'] = strtolower(str_replace(' ', '_', $dishItem->dish_type_name));
                $sortedData[$dishItem->day][$dishItem->dish_type_id]['dishList'][$dishItem->id] = $dishItem->name;
                $sortedData[$dishItem->day][$dishItem->dish_type_id]['dishPrice'][$dishItem->id] = $dishItem->price;
            }

            foreach ($sortedData as $day => $value) {
                $finalData[$day] = array_values($value);
            }
        }
        return $finalData;
    }

    public function reArrangeSubscriptionPostData($postData)
    {
        $response = [];
        $orderTypeId = $postData['orderTypeId'];
        $newPostData = $this->arrangeDayWisePostData($postData);

        /* Created array of all dish type we have in db and formatting them in lowercase and replacing space with underscore */
        $dishTypes = DishType::all('name')->pluck('name')
            ->map(function ($value, $key) {
                return strtolower(str_replace(' ', '_', $value));
            })->all();

        $orderTotalAmount = 0;
        foreach ($newPostData as $day => $postData) {

            $finalItemList = $this->orderService->createFinalDetailedItemList($dishTypes, $postData);
            if (!empty($finalItemList['orderTotalAmount']) && !empty($finalItemList['items'])) {
                $response[$day]['orderTotalAmount'] = $finalItemList['orderTotalAmount'];
                $response[$day]['orderTypeId'] = $orderTypeId;
                $response[$day]['items'] = $finalItemList['items'];
            }
        }
        return $response;
    }

    public function arrangeDayWisePostData($postData)
    {
        $newPostData = [];

        // $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $weekdays = $postData['days'];

        $monday = array_filter($postData, function ($key) {
            return strpos($key, 'monday') === 0;
        }, ARRAY_FILTER_USE_KEY);
        $tuesday = array_filter($postData, function ($key) {
            return strpos($key, 'tuesday') === 0;
        }, ARRAY_FILTER_USE_KEY);
        $wednesday = array_filter($postData, function ($key) {
            return strpos($key, 'wednesday') === 0;
        }, ARRAY_FILTER_USE_KEY);
        $thursday = array_filter($postData, function ($key) {
            return strpos($key, 'thursday') === 0;
        }, ARRAY_FILTER_USE_KEY);
        $friday = array_filter($postData, function ($key) {
            return strpos($key, 'friday') === 0;
        }, ARRAY_FILTER_USE_KEY);
        $saturday = array_filter($postData, function ($key) {
            return strpos($key, 'saturday') === 0;
        }, ARRAY_FILTER_USE_KEY);

        foreach ($weekdays as $day) {
            foreach ($$day as $key => $value) {
                $newKey = str_replace($day . '_', '', $key);
                $newPostData[$day][$newKey] = $value;
            }
        }

        return $newPostData;
    }

    /**
     * Process order form data.
     * @param (array)postData
     * @return void
     */
    public function processData($addressId)
    {
        $orderData = session('subscriptionOrderData');
        $orderParams['orderTypeId'] = session('orderTypeId');
        $orderParams['shippingAddressId'] = $addressId;
        $orderParams['subscriptionItems'] = json_encode($orderData);

        return $this->insertSubscriptionOrderIntoTable($orderParams);
    }

    /**
     * Insert subscription in table
     */
    private function insertSubscriptionOrderIntoTable($orderParams)
    {
        DB::beginTransaction();
        try {
            $subscription = new Subscription;
            $subscription->user_id = Auth::id();
            $subscription->order_type_id = $orderParams['orderTypeId'];
            $subscription->shipping_address_id = $orderParams['shippingAddressId'];
            $subscription->subscription_items = $orderParams['subscriptionItems'];
            $subscription->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }
    }

}
