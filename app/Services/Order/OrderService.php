<?php

/**
 * Service for order related operations.
 *
 * @author Anil G.
 */

namespace App\Services\Order;

use App\Model\Dish;
use App\Model\DishType;

class OrderService
{

    private $dishes;

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

        $orderTypeId = $postData['orderTypeId'];
        unset($postData['orderTypeId'], $postData['_token']);

        $inputArray = $this->rearrangeOrderPostData($postData);

        dd($inputArray);

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

        /* Looping through each dish type and checking which are sent over post data  */
        foreach ($dishTypes as $dishTypeName) {
            /* If post data contains dish type then create new array with 'dish_id' and 'quantity' */
            if (array_key_exists($dishTypeName, $postData) && $dishTypeName != 'others') {
                /* If value is not selected from drop down or quantity is empty then do not add those in response node */
                if (!empty($postData[$dishTypeName]) && !empty($postData['qty_' . $dishTypeName])) {
                    $response[$dishTypeName]['dish_id'] = $postData[$dishTypeName];
                    $response[$dishTypeName]['qty'] = $postData['qty_' . $dishTypeName];
                }
                /* Unsetting items so that at the end of loop we will have only "others" type of dishes in "postdata" node */
                unset($postData[$dishTypeName], $postData['qty_' . $dishTypeName]);
            }

        }

        /* If post data contains other type of dishes then push them to response node */
        if (!empty($postData)) {
            $response['others']['dish_id'] = array_values($postData);
        }
        return $response;
    }

}
