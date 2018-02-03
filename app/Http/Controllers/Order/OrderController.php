<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\OrderType;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {

        $this->orderService = $orderService;

    }

    /**
     * Show the application order form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderForm($orderType)
    {

        /* fetch order type data based on order type */
        $orderTypeData = OrderType::where('name', $orderType)->first();

        /* If invalid order type passed in url then redirect to previous page */
        if (empty($orderTypeData)) {
            return redirect()->back();
        }

        $orderTypeId = $orderTypeData->id;

        /* Fetch Dish list from service */
        $dishData = $this->orderService->getDishList();
        $dishList['orderTypeId'] = $orderTypeId;
        $dishList['dishData'] = $dishData;

        // echo '<pre>'; print_r($dishList);exit;

        return view('order', ['dishes' => $dishList]);
    }

    /**
     * Process the application order form.
     *
     * @return \Illuminate\Http\Response
     */
    public function processOrder(Request $request)
    {
        // $user = Auth::id();
        // dd($user);
        $input = $request->all();
        $this->orderService->processData($input);

    }

}
