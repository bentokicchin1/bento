<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Model\OrderType;

class OrderController extends Controller
{
     /**
     * Show the application order form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderForm($orderType){

        // fetch order type data based on order type
        $orderTypeData = OrderType::where('name', $orderType)->first();        

        // if in valide order type passed the redirect to previous page
        if(empty($orderTypeData)){
            return redirect()->back();
        }

        return view('order', ['typeId'=>$orderTypeData->id]);
    }

    public function processOrder(Request $request){
        dd($request->all());
    }
}
