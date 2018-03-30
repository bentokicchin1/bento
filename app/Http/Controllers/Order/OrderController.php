<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderType;
use App\Services\Customer\AddressService;
use App\Services\Checkout\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $orderService;
    private $addressService;

    public function __construct(OrderService $orderService, AddressService $addressService)
    {
        $this->orderService = $orderService;
        $this->addressService = $addressService;
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
        $date = date('Y-m-d');
        $dishData = $this->orderService->getDishList($orderTypeId,$date);
        $dishList['orderTypeId'] = $orderTypeId;
        $dishList['dishData'] = $dishData;
        // echo "<pre/>";
        // print_r($dishList);
        // exit;
        return view('order.menu', ['dishes' => $dishList]);
    }

    /**
     * Show address select and order summary page.
     *
     * @return \Illuminate\Http\Response
     */
    public function addressSelect(Request $request)
    {
        $postData = $request->all();
        if (!empty($postData)) {
            /* Rearrange post data */
            $sortedPostData = $this->orderService->rearrangeOrderPostData($postData);

            /* Validate sorted input data and redirect if error occurs. */
            $validationMessage = $this->orderService->validateOrderFormData($sortedPostData);
            if ($validationMessage != 'success') {
                return redirect()->back()->withErrors($validationMessage);
            }

            /* Remove existing order data from session and add new one. */
            if ($request->session()->has('orderData')) {
                $request->session()->forget('orderData');
            }
            $request->session()->put('orderData', $sortedPostData);
        } elseif ($request->session()->get('orderData')) {
            /* Check if order data present in session */
            $sortedPostData = $request->session()->get('orderData');
        } else {
            /* if no order data found then redirect to home page */
            return redirect()->route('home');
        }

        /* Fetch customer address list and create array that need to be sent to checkout view page */
        $viewData['addressList'] = $this->addressService->getAddressList();
        $viewData['orderData'] = $sortedPostData;

        /* Pass customer address list and order data to checkout page */
        return view('order.checkout', $viewData);
    }

    /**
     * Process Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function processOrder(Request $request)
    {
        $postData = $request->all();

        $resCycle = $this->orderService->checkBillingCycle();
        if(!empty($resCycle)) {
            return redirect()->route('profile')->withErrors('Please select billing cycle.');
        }
        if (empty($postData['addressId'])) {
            return redirect()->back()->withErrors('Please select address.');
        }
        $addressId = $postData['addressId'];
        $response = $this->orderService->processData($addressId);
        if ($response == 'success') {
            $request->session()->forget('orderData');
            return redirect()->route('confirmation');
        }
    }

    public function confirmOrder(){
        return view('order.confirmation');
    }

}
