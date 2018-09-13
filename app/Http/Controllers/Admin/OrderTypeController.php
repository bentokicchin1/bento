<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Model\OrderType;
use DB;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $orderTypesData = [];
        if (!empty($id)) {
            $orderTypesData = OrderType::all()->where('id', $id)->first();
        }
        return view('admin.orderType.add', ['orderTypesData' => $orderTypesData]);
    }

    public function index()
    {
        $orderTypes = OrderType::all();
        return view('admin.orderType.list', ['orderType' => $orderTypes]);
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
                $orderTypeObj = OrderType::find($id);
            } else {
                $orderTypeObj = new OrderType;
            }
            $orderTypeObj->name = $request->input('name');
            $orderTypeObj->save();

            DB::commit();
            return redirect()->route('admin-order-type-list')->with('status', 'Order type added successfully!');
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
                OrderType::destroy($id);
                return redirect()->back()->with('status', 'Order type deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
