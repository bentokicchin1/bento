<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $orders = [];
        if (!empty($id)) {
          $orders = Order::getOrderDetails($id);
        }
        return view('admin.orders.orderAdd', ['orders' => $orders]);
    }

    public function index()
    {
        DB::enableQueryLog();
        $orders = Order::with('shipping_address','shipping_address.cityData','shipping_address.areaData','shipping_address.areaLocation')
                  ->with('users')
                  ->with('orderType')
                  ->get();
        return view('admin.orders.orderList', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        $id = $request->input('id');
        try {
            if (!empty($id)) {
                $orderObj = order::find($id);
            } else {
                $orderObj = new order;
            }
            $orderObj->name = $request->input('name');
            $orderObj->save();

            DB::commit();
            return redirect()->route('admin-dish-type-list')->with('status', 'Order added successfully!');
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
                Order::destroy($id);
                return redirect()->back()->with('status', 'Order deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
