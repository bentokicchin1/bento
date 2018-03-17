<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\User;
use App\Model\OrderType;
use App\Model\WeeklyDishList;
use App\Services\Customer\AddressService;
use App\Services\Checkout\OrderService;
use DB;
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

    public function showForm($id = '', Request $request)
    {
        $orders = [];
        $userData = User::offset(0)->limit(10)->pluck('name','id');
        $orderTypeData = OrderType::pluck('name', 'id');
        if (!empty($id)) {
          $orderData = Order::where('id', $id)->first();
          $orderTypeId = $orderData->order_type_id;
          $orderDate = $orderData->created_at;
          $dishData = $this->orderService->getDishList($orderTypeId,$orderDate);
        }else {
           $orderDate = date('Y-m-d H:i:s');
           $dishData = $this->orderService->getDishList(2,$orderDate);
        }
        return view('admin.orders.orderAdd', ['orders' => $orders,'dishData'=>$dishData,'orderTypeData'=>$orderTypeData,'userData'=>$userData]);
    }

    public function index()
    {
        $orders = Order::with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                  ->with('users')
                  ->with('orderType')
                  ->get();
        return view('admin.orders.orderList', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
          $postData = $request->all();
          // echo "<pre/>";
          // print_r($postData);
          // exit;
          $validatedData = $request->validate([
              'user' => 'required',
              'orderTypeId' => 'required'
          ]);
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

              $addressId = 6;
              $response = $this->orderService->processData($addressId);
              return redirect()->route('admin-order-list')->with('status', 'Order added successfully!');
          } elseif ($request->session()->get('orderData')) {
              /* Check if order data present in session */
              $sortedPostData = $request->session()->get('orderData');
          }
  }

    /**
     * Soft delete order type
     *
     */
    public function delete($id, Request $request)
    {
        if (!empty($id)) {
            try {
                Order::destroy($id);
                return redirect()->back()->with('status', 'Order deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
