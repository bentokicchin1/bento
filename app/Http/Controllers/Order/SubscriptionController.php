<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderType;
use App\Services\Customer\AddressService;
use App\Services\Checkout\OrderService;
use App\Services\Checkout\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private $subscriptionService;
    private $addressService;
    private $orderService;

    public function __construct(SubscriptionService $subscriptionService, AddressService $addressService, OrderService $orderService)
    {
        $this->subscriptionService = $subscriptionService;
        $this->addressService = $addressService;
        $this->orderService = $orderService;
    }

    /**
     * Show the application order form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubscriptionOrderTypeForm()
    {
        return view('subscription.subscriptionType');
    }

    /**
     * Show address select and order summary page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubscriptionForm($orderType, Request $request)
    {
        /* fetch order type data based on order type */
        $orderTypeData = OrderType::where('name', $orderType)->first();

        /* If invalid order type passed in url then redirect to previous page */
        if (empty($orderTypeData)) {
            return redirect()->back();
        }

        $orderTypeId = $orderTypeData->id;

        /* Below session orderTypeId variable is used while inserting subscription data in subscription table */
        /* Remove existing order type id from session and add new one. */
        if ($request->session()->has('orderTypeId')) {
            $request->session()->forget('orderTypeId');
        }
        $request->session()->put('orderTypeId', $orderTypeId);

        /* Fetch Dish list from service */
        $dishData = $this->subscriptionService->getDishList($orderTypeId);

        $dishList['orderTypeId'] = $orderTypeId;
        $dishList['dishData'] = $dishData;

        return view('subscription.subscriptionMenu', ['dishes' => $dishList]);
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
            $sortedPostData = $this->subscriptionService->reArrangeSubscriptionPostData($postData);

            /* Validate sorted input data and redirect if error occurs. */
            foreach ($sortedPostData as $day => $eachDayItems) {
                $validationMessage = $this->orderService->validateOrderFormData($eachDayItems);
                if ($validationMessage != 'success') {
                    return redirect()->back()->withInput()->withErrors("Total amount must be greater than Rs. 45 for " . ucfirst($day));
                }
            }

            /* Remove existing order data from session and add new one. */
            if ($request->session()->has('subscriptionOrderData')) {
                $request->session()->forget('subscriptionOrderData');
            }
            $request->session()->put('subscriptionOrderData', $sortedPostData);

        } elseif ($request->session()->get('subscriptionOrderData')) {
            /* Check if subscription order data present in session */
            $sortedPostData = $request->session()->get('subscriptionOrderData');
        } else {
            /* if no order data found then redirect to home page */
            return redirect()->route('home');
        }
        /* Fetch customer address list and create array that need to be sent to checkout view page */
        $viewData['addressList'] = $this->addressService->getAddressList();
        $viewData['orderData'] = $sortedPostData;

        /* Pass customer address list and order data to checkout page */
        return view('subscription.subscriptionCheckout', $viewData);

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
        if (!empty($resCycle)) {
            return redirect()->route('profile')->withErrors('Please select billing cycle.');
        }
        if (empty($postData['addressId'])) {
            return redirect()->back()->withErrors('Please select address.');
        }

        echo "<pre/>";
        print_r(session()->all());
        exit;
        $addressId = $postData['addressId'];
        $response = $this->subscriptionService->processData($addressId);
        echo "<pre/>";
        print_r($response);
        exit;

        if ($response == 'success') {
            $request->session()->forget('subscriptionOrderData');
            return redirect()->route('subscriptionConfirmation');
        }
    }

    public function confirmSubscription(){
        return view('subscription.subscriptionConfirmation');
    }
}
