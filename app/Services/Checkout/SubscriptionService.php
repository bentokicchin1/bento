<?php

/**
 * Service for subscription related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Checkout;

use DB;
use App\Model\User;
use App\Model\Dish;
use App\Model\DishType;
use App\Model\WeeklyDishList;
use App\Model\Order;
use App\Model\OrderType;
use App\Model\Subscription;
use App\Services\Checkout\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DefaultSubscriptionPlaced;

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


    public function getDefaultDishList($orderTypeId)
    {
        $finalData = array();
        $rawDishList = $this->dishes->getDefaultDishListfromDb($orderTypeId);
        if(!empty($rawDishList)){
            foreach($rawDishList as $key => $dishItem) {
              $items = array();
              $day = strtolower($dishItem->day);
              $dishType = strtolower($dishItem->dish_type_name);
              if(!array_key_exists($day,$finalData)){
                  $finalData[$day] = array();
                  $finalData[$day]['orderTotalAmount'] = 0;
                  $finalData[$day]['orderTypeId'] = $dishItem->order_type_id;
                  $finalData[$day]['items'] = array();
              }
              if(!array_key_exists($dishType,$finalData[$day]['items'])){
                  $finalData[$day]['items'][$dishType] = array();
              }
              if($dishType!='others'){
                $finalData[$day]['items'][$dishType]['dish_id'] =  $dishItem->id;
                $qty =  ($dishType=='chapati') ? 3 : 1;
                $finalData[$day]['items'][$dishType]['qty'] = $qty;
                $finalData[$day]['items'][$dishType]['name'] =  $dishItem->name;
                $finalData[$day]['items'][$dishType]['food_type'] = $dishItem->dish_food_type;
                $finalData[$day]['items'][$dishType]['base_price'] =  $dishItem->price;
                $finalData[$day]['items'][$dishType]['total_price'] =  $dishItem->price * $qty;
                $finalData[$day]['orderTotalAmount'] += $finalData[$day]['items'][$dishType]['total_price'];
              }else{
                $others = array();
                $others['dish_id'] =  $dishItem->id;
                $others['qty'] = 1;
                $others['name'] =  $dishItem->name;
                $others['food_type'] = $dishItem->dish_food_type;
                $others['base_price'] =  $dishItem->price;
                $others['total_price'] =  $dishItem->price * $qty;
                array_push($finalData[$day]['items'][$dishType],$others);
                $finalData[$day]['orderTotalAmount'] += $dishItem->price;

              }
            }
        }
        return $finalData;
    }

    /**
     * Process default subscription
     * @param (array)postData
     * @return void
     */
    public function processDefaultSubscription($orderParams,$userId)
    {
        return $this->insertSubscriptionOrderIntoTable($orderParams,$userId);
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
        $finalData =  [];
        $currentDateTime = date('Y-m-d h:i a');
        $daysArray = WeeklyDishList::getDatesForThisWeek();
        if(!empty($rawDishList)){
            foreach($rawDishList as $key => $dishItem) {
              if($dishItem->order_type_id==config('constants.ORDER_TYPE_LUNCH')){
                  $maxDate = date('Y-m-d')." ".config('constants.LUNCH_ORDER_MAX_TIME');
              } elseif($dishItem->order_type_id==config('constants.ORDER_TYPE_DINNER')) {
                  $maxDate = date('Y-m-d')." ".config('constants.DINNER_ORDER_MAX_TIME');
              }
              if(date('Y-m-d',strtotime($dishItem->date))==date('Y-m-d') && strtotime($currentDateTime) <= strtotime($maxDate) || date('Y-m-d',strtotime($dishItem->date))>date('Y-m-d')) {
                  $sortedData[$dishItem->date][$dishItem->dish_type_id]['dishTypeId'] = $dishItem->dish_type_id;
                  $sortedData[$dishItem->date][$dishItem->dish_type_id]['dishTypeName'] = strtolower(str_replace(' ', '_', $dishItem->dish_type_name));
                  $sortedData[$dishItem->date][$dishItem->dish_type_id]['dishList'][$dishItem->id] = $dishItem->name;
                  $sortedData[$dishItem->date][$dishItem->dish_type_id]['dishPrice'][$dishItem->id] = $dishItem->price;
              }
            }
            foreach($daysArray as $dateFromDay){
                foreach ($sortedData as $date => $value) {
                    $day = date('l',strtotime($dateFromDay));
                    if(empty($finalData[$day])){
                        if($date==$dateFromDay){
                          $finalData[$day] = array_values($value);
                        }else{
                          $finalData[$day] = array();
                        }
                    }
                }
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
            return strpos($key, 'monday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $tuesday = array_filter($postData, function ($key) {
            return strpos($key, 'tuesday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $wednesday = array_filter($postData, function ($key) {
            return strpos($key, 'wednesday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $thursday = array_filter($postData, function ($key) {
            return strpos($key, 'thursday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $friday = array_filter($postData, function ($key) {
            return strpos($key, 'friday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $saturday = array_filter($postData, function ($key) {
            return strpos($key, 'saturday') > 0;
        }, ARRAY_FILTER_USE_KEY);
        $sunday = array_filter($postData, function ($key) {
            return strpos($key, 'sunday') > 0;
        }, ARRAY_FILTER_USE_KEY);

        foreach ($weekdays as $day) {
            foreach ($$day as $key => $value) {
                $newKey = str_replace('_'.$day, '', $key);
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
    private function insertSubscriptionOrderIntoTable($orderParams,$userId=0)
    {
        DB::beginTransaction();
        try {
            $sub = array();
            $userId = ($userId==0) ? Auth::id() : $userId;
            $orderTypeId = $orderParams['orderTypeId'];
            $existingSub = Subscription::withTrashed()->where(['user_id'=>$userId,'order_type_id'=>$orderTypeId])->first();
            if(!empty($existingSub)){
              $subscriptionId = $existingSub->id;
              $subscription = Subscription::withTrashed()->where(['id'=>$subscriptionId])->first();
              $subscription->updated_at = date('Y-m-d H:i:s');
              $subscription->deleted_at = NULL;
            }else{
              $subscription = new Subscription;
            }
            $subscription->user_id = $userId;
            $subscription->order_type_id = $orderParams['orderTypeId'];
            $subscription->shipping_address_id = $orderParams['shippingAddressId'];
            $subscription->subscription_items = $orderParams['subscriptionItems'];
            $subscription->save();
            
            $user = User::find($userId);
            $userEmail = $user->email;
            $sub['name'] = $user->name;
            $orderType = OrderType::find($orderParams['orderTypeId']);
            $sub['orderType'] = $orderType->name;
            $sub['items'] = json_decode($orderParams['subscriptionItems'], true);
            Mail::to($userEmail)->send(new DefaultSubscriptionPlaced($sub));
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getRawMessage();
        }
    }

}
