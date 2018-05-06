<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderType;
use App\Model\WeeklyDishList;
use App\Model\Subscription;
use App\Services\Customer\AddressService;
use App\Services\Checkout\OrderService;
use App\Services\Checkout\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $subscribedDishes = array();
        /* fetch order type data based on order type */
        $orderTypeData = OrderType::where('name', $orderType)->first();
        $daysArray = WeeklyDishList::getDatesForThisWeek();
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
        $subscribed = Subscription::where(['user_id'=>Auth::id(),'order_type_id'=>$orderTypeId])->first();
        if(!empty($subscribed)){
          $subscribedDishes = json_decode($subscribed->subscription_items,true);
        }
        /* Fetch Dish list from service */
        $dishData = $this->subscriptionService->getDishList($orderTypeId);
        $dishList['orderTypeId'] = $orderTypeId;
        $dishList['dishData'] = $dishData;
        return view('subscription.subscriptionMenu', ['subscribedDishes'=>$subscribedDishes,'dishes' => $dishList,'daysArray'=>$daysArray]);
    }

    /**
     * Show address select and order summary page.
     *
     * @return \Illuminate\Http\Response
     */
    public function addressSelect(Request $request)
    {

        $userId = Auth::id();
        $postData = $request->all();
        if (!empty($postData)) {
            $orderTypeId = $postData['orderTypeId'];
            $rules = [
                'days' => 'required'
            ];
            $customMessages = [
               'days.required' => 'Please select tiffin details for atleast one day.'
            ];
            $this->validate($request, $rules, $customMessages);
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
        if(empty($orderTypeId) && $request->session()->has('orderTypeId')){
          $orderTypeId = $request->session()->get('orderTypeId');
        }
        /* Fetch customer address list and create array that need to be sent to checkout view page */
        $viewData['addressStored'] = $this->addressService->getAddressByUserOrder($userId,$orderTypeId);
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

        $addressId = $postData['addressId'];
        $response = $this->subscriptionService->processData($addressId);

        if ($response == 'success') {
            $request->session()->forget('subscriptionOrderData');
            return redirect()->route('subscriptionConfirmation');
        }
    }

    public function confirmSubscription(){
        return view('subscription.subscriptionConfirmation');
    }
}
