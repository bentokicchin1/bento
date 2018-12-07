<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\User;
use App\Model\OrderType;
use App\Model\OrderItem;
use App\Model\WeeklyDishList;
use App\Services\Customer\AddressService;
use App\Services\Checkout\OrderService;
use DB;
use Response;
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
        $dishData = array();
        $ordersData = $dishList = $orderItems = $orderItems['orderTypeIds'] = [];
        $userData = User::pluck('name','id');
        $orderTypeData = OrderType::pluck('name', 'id');
        if (!empty($id)) {
//          $ordersData = Order::with('users')
//                    ->with('orderType')
//                    ->with('orderItems.orderDish')
//                    ->where("orders.deleted_at", NULL)
//                    ->where('id',$id)->first()->toArray();
//          $orderItems = $this->orderService->formatOrderItems($ordersData);
            $orderItems = $this->orderService->getSingleOrderDetails($id);
            $orderItems['orderTypeIds'] = [];
            $orderTypeId = $ordersData['order_type_id'];
            $orderDate = $ordersData['order_date'];
            $dishData = $this->orderService->getDishListForAdmin($orderTypeId,$orderDate);
            $dishList['orderTypeId'] = $orderTypeId;
            $dishList['dishData'] = $dishData;
        }
        return view('admin.orders.orderAdd', ['dishes'=>$dishList,'ordersData'=>$ordersData,'orderItems'=>$orderItems,'dishData'=>$dishData,'orderTypeData'=>$orderTypeData,'userData'=>$userData]);
    }

    public function index()
    {
        $orders = Order::with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                  ->with('users')
                  ->with('orderType')
                  ->where("orders.deleted_at", NULL)
                  ->get();
        return view('admin.orders.orderList', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
      $postData = $request->all();
      $validatedData = $request->validate([
          'orderDate' =>'required',
          'user' => 'required',
          'orderTypeId' => 'required'
      ]);
          DB::beginTransaction();
          try{
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

              $userId = $postData['user'];
              $orderTypeId = $postData['orderTypeId'];
              $addressData = $this->addressService->getAddressByUserOrder($userId,$orderTypeId);
              if (empty($addressData)) {
                  return redirect()->back()->withErrors("Address not in database for this user and selected order type");
              }else{
                $addressId = $addressData->id;
                $response = $this->orderService->processData($addressId);
              }
          } elseif ($request->session()->get('orderData')) {
              /* Check if order data present in session */
              $sortedPostData = $request->session()->get('orderData');
          }
          DB::commit();
          return redirect()->route('admin-order-list')->with('status', 'Order added successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Something went wrong. Please try again.');
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
                $order = Order::findOrFail($id);
                // $order->orderItems()->delete($id);
                $order->delete($id);
                return redirect()->back()->with('status', 'Order deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

   public function getDishList(Request $request)
   {
     $dishResponse = array();
     $validatedData = $request->validate([
         'orderDate' =>'required',
         'orderTypeId' => 'required'
     ]);

     try{
          $orderTypeId = $request->input('orderTypeId');
          $orderDate = $request->input('orderDate');
          $dishData = $this->orderService->getDishListForAdmin($orderTypeId,$orderDate);
          $dishDetails =  '<label class="col-sm-3 control-label" style="padding-top:7px">Order Details</label><div class="row  col-sm-6">';
            if(!empty($dishData)){
              foreach ($dishData as $dish){
                  if ($dish['dishTypeName'] != 'others'){
                    $dishDetails .=  '<div class="form-group"><div class="col-sm-6"><select name='.$dish["dishTypeName"].' class="form-control dropdown" data-placeholder= "Please select '.$dish["dishTypeName"].'"><option val=""></option>';
                    foreach($dish["dishList"] as $dishId=>$dishName){
                        $dishDetails .=  '<option value="'.$dishId.'">'.$dishName.'</option>';
                    }
                    $dishDetails .= '</select></div>';
                    $dishDetails .= '<div class="col-sm-3"><input type="textbox" name="qty_'.$dish["dishTypeName"].'" class="form-control" placeholder="Quantity" value="'.old('qty_'.$dish["dishTypeName"]).'"></div></div>';
                  }else{
                    $dishDetails .=  '<div class="checkbox">';
                    foreach($dish['dishList'] as $dishId => $dishName){
                        $dishDetails .=  '<label><input type="checkbox" value="'.$dishId.'" name='.$dish["dishTypeName"].'_'.strtolower($dishName).'" ><span>'.$dishName.' ( <i class="fas fa-rupee-sign"></i>'.round($dish["dishPrice"][$dishId]).')</span></label>';
                    }
                    $dishDetails .=  '</div>';
                  }
                }
            }else{
                $dishDetails .=  '<h4 style="text-align:center;">No data found</h4>';
            }
            $dishDetails .= '</div></div>';
            $dishResponse['dishDetails'] = $dishDetails;
          return Response::json($dishResponse);
     } catch (Exception $e) {

     }
   }

}
