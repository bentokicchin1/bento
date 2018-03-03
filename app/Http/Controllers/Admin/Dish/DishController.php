<?php

namespace App\Http\Controllers\Admin\Dish;

use App\Http\Controllers\Controller;
use App\Model\DishType;
use DB;
use Illuminate\Http\Request;

class DishController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $dishTypesData = [];
        if (!empty($id)) {
            $dishTypesData = DishType::all()->where('id', $id)->first();
        }
        return view('admin.dishType.add', ['dishTypesData' => $dishTypesData]);
    }

    public function index()
    {
        $dishTypes = DishType::all();
        return view('admin.dishType.list', ['dishType' => $dishTypes]);
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
                $dishTypeObj = dishType::find($id);
            } else {
                $dishTypeObj = new dishType;
            }
            $dishTypeObj->name = $request->input('name');
            $dishTypeObj->save();

            DB::commit();
            return redirect()->route('admin-dish-type-list')->with('status', 'Dish type added successfully!');
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
                DishType::destroy($id);
                return redirect()->back()->with('status', 'Dish type deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
