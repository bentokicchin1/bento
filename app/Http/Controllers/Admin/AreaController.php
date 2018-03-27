<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Area;
use DB;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $areaData =  [];
        if (!empty($id)) {
            $areaData = Area::all()->where('id', $id)->first();
        }
        return view('admin.locations.areaAdd', ['areaData' => $areaData]);
    }

    public function index()
    {
        $area =  Area::with('cityName')->get();
        return view('admin.locations.areaList', ['area' => $area]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        DB::beginTransaction();
        $id = $request->input('id');
        try {
            if (!empty($id)) {
                $areaObj = area::find($id);
            } else {
                $areaObj = new area;
            }

            $areaObj->city_id = config('constants.DEFAULT_CITY');
            $areaObj->name = $request->input('name');
            $areaObj->save();

            DB::commit();
            return redirect()->route('admin-area-list')->with('status', 'Area added successfully!');
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
                Area::delete($id);
                return redirect()->back()->with('status', 'Area deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
