<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Dish;
use App\Model\DishType;
use DB;
use Illuminate\Http\Request;

class DishController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $dishTypesData = $dishData = [];
        $dishData = DishType::pluck('name', 'id');
        if (!empty($id)) {
            $dishTypesData = Dish::all()->where('id', $id)->first();
        }
        // echo "<pre/>";print_r($dishData);
        // exit;
        return view('admin.dishes.dishAdd', ['dishTypesData' => $dishTypesData,'dishData'=>$dishData]);
    }

    public function index()
    {
        $dishTypes =  Dish::with('dishtype')->get();
        return view('admin.dishes.dishList', ['dishType' => $dishTypes]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dishTypeId' => 'required',
            'name' => 'required',
            'price' => 'required',
            'dishImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        $id = $request->input('id');
        try {
            if (!empty($id)) {
                $dishTypeObj = dish::find($id);
            } else {
                $dishTypeObj = new dish;
            }

            if ($request->hasFile('dishImage')) {
              $image = $request->file('dishImage');
              $name = time().'.'.$image->getClientOriginalExtension();
              $destinationPath = public_path('/uploads');
              $image->move($destinationPath, $name);
              $dishTypeObj->image = url('/')."/uploads/".$name;
            }
            $dishTypeObj->dish_type_id = $request->input('dishTypeId');
            $dishTypeObj->name = $request->input('name');
            $dishTypeObj->price = $request->input('price');
            $dishTypeObj->description = $request->input('description');
            $dishTypeObj->save();

            DB::commit();
            return redirect()->route('admin-dish-list')->with('status', 'Dish added successfully!');
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
                  $dish = Dish::where('id', $id)->first(); // File::find($id)
                  if($dish) {
                      if (!empty($dish->order_items()->get()) || !empty($dish->weeklyMenu()->get())) {
                        return redirect()->back()->withErrors('This dish is associated some order. So can not delete dish.');
                      }else{
                        Dish::destroy($id);
                        return redirect()->back()->with('status', 'Dish deleted successfully!');
                      }
                  }
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
