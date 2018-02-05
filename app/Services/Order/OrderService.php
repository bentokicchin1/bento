<?php

/**
 * Service for order related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Order;

use App\Model\Dish;
use App\Model\DishType;
use Illuminate\Support\Facades\Auth;

class OrderService
{

    private $dishes;
    private $userId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Dish $dishes)
    {

        $this->dishes = $dishes;

    }

    public function getDishList()
    {
        $rawDishList = $this->dishes->getDishListfromDb();
        return $this->formatDishList($rawDishList);
    }

    public function formatDishList($rawDishList)
    {

        $sortedData = [];
        foreach ($rawDishList as $key => $dishItem) {

            $sortedData[$dishItem->dish_type_id]['dishTypeId'] = $dishItem->dish_type_id;
            $sortedData[$dishItem->dish_type_id]['dishTypeName'] = strtolower(str_replace(' ', '_', $dishItem->dish_type_name));
            $sortedData[$dishItem->dish_type_id]['dishList'][$dishItem->id] = $dishItem->name;
            $sortedData[$dishItem->dish_type_id]['dishPrice'][$dishItem->id] = $dishItem->price;

        }
        return array_values($sortedData);
    }

    /**
     * Process order form data.
     * @param (array)postData
     * @return void
     */
    public function processData($postData)
    {
        
        $orderParams['orderTypeId'] = $postData['orderTypeId'];
        $orderParams['quantity'] = 1;
        

        unset($postData['orderTypeId'], $postData['_token']);

        $sortedPostData = $this->rearrangeOrderPostData($postData);
        $orderParams['shippingAddress'] = 1;
        $orderParams['orderTotalAmount'] = $sortedPostData['orderTotalAmount'];
        dd($orderParams);

    }

    public function rearrangeOrderPostData($postData)
    {

        $response = [];
        /* Created array of all dish type we have in db and formatting them in lowercase and replacing space with underscore */
        $dishTypes = DishType::all('name')->pluck('name');
        $filtered = $dishTypes->map(function ($value, $key) {
            return strtolower(str_replace(' ', '_', $value));
        });
        $dishTypes = $filtered->all();

        /* Fetched dishes id-price array */
        // $dishesPriceArray = Dish::all('id', 'price', 'name')->pluck('price', 'id', 'name')->all();
        
        $orderTotalAmount = 0;
        /* Looping through each dish type and checking which are sent over post data  */
        foreach ($dishTypes as $dishTypeName) {
            /* If post data contains dish type then create new array with 'dish_id' and 'quantity' */
            if (array_key_exists($dishTypeName, $postData) && $dishTypeName != 'others') {
                /* If value is not selected from drop down or quantity is empty then do not add those in response node */
                if (!empty($postData[$dishTypeName]) && !empty($postData['qty_' . $dishTypeName])) {

                    $dishId = $postData[$dishTypeName];
                    $dishDetail = $this->getDishDetailById($dishId);
                    $response[$dishTypeName]['dish_id'] = $dishId;
                    $response[$dishTypeName]['qty'] = $postData['qty_' . $dishTypeName];
                    $response[$dishTypeName]['name'] = $dishDetail->name;
                    $response[$dishTypeName]['base_price'] = $dishDetail->price;
                    $response[$dishTypeName]['total_price'] = $dishDetail->price * $postData['qty_' . $dishTypeName];

                    $orderTotalAmount += $dishDetail->price * $postData['qty_' . $dishTypeName];
                }
                /* Unsetting items so that at the end of loop we will have only "others" type of dishes in "postdata" node */
                unset($postData[$dishTypeName], $postData['qty_' . $dishTypeName], $dishDetail);
            }
        }

        /* If post data contains other type of dishes then push them to response node */
        if (!empty($postData)) {
            $i = 0;
            foreach ($postData as $key => $dishId) {

                $dishDetail = $this->getDishDetailById($dishId);
                $response['others'][$i]['dish_id'] = $dishId;
                $response['others'][$i]['qty'] = 1;
                $response['others'][$i]['name'] = $dishDetail->name;
                $response['others'][$i]['base_price'] = $dishDetail->price;
                $response['others'][$i]['total_price'] = $dishDetail->price;

                $orderTotalAmount +=$dishDetail->price;
                $i++;
            }
            $response['orderTotalAmount'] = $orderTotalAmount;
            // $response['others']['dish_id'] = array_values($postData);
        }
        return $response;
    }

    /**
     * Return dish detail by id.
     * @param (int)dish id
     * @return (object) dish details
     */
    public function getDishDetailById($dishId){
        return Dish::select('price', 'name')->where('id',$dishId)->first();
    }
    
}
