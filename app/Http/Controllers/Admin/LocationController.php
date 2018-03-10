<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Area;
use App\Model\Area_location;
use DB;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $areaLocationData = $areaData = [];
        $areaData = Area::pluck('name', 'id');
        if (!empty($id)) {
            $areaLocationData = Area_location::all()->where('id', $id)->first();
        }
        return view('admin.locations.locationAdd', ['areaLocationData' => $areaLocationData,'areaData'=> $areaData]);
    }

    public function index()
    {
        $areaLocation =  Area_location::with('area')->get();
        return view('admin.locations.locationList', ['areaLocation' => $areaLocation]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'areaId' => 'required',
            'name' => 'required'
        ]);

        DB::beginTransaction();
        $id = $request->input('id');
        try {
            if (!empty($id)) {
                $areaLocationObj = area_location::find($id);
            } else {
                $areaLocationObj = new area_location;
            }

            $areaLocationObj->area_id = $request->input('areaId');
            $areaLocationObj->name = $request->input('name');
            $areaLocationObj->save();

            DB::commit();
            return redirect()->route('admin-location-list')->with('status', 'AreaLocation added successfully!');
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
                Area_location::destroy($id);
                return redirect()->back()->with('status', 'AreaLocation type deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

}
