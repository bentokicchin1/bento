<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DishType;
use App\Model\Dish;
use App\Model\OrderType;
use App\Model\City;
use App\Model\WeeklyDishList;
use DB;
use Illuminate\Http\Request;

class WeeklymenuController extends Controller
{

    public function showForm($id = '', Request $request)
    {
        $dishTypeSelect = $dayList = [];
        $dayList = config('constants.days');

        $menuArray = self::getTotalWeekData();
        $orderTypeData = OrderType::pluck('name', 'id');
        $dishTypeData = DishType::pluck('name', 'id');
        $dishes = DB::table('dishes')
                ->select("dishes.id as dish_id", "dishes.name as dishName", "dish_types.id as dish_type_id", "dish_types.name as dishTypeName")
                ->join("dish_types","dish_types.id","=","dishes.dish_type_id")
                ->get();

        foreach ($dishTypeData as $dishTypeId => $dishTypeName) {
            foreach ($dishes as $dishId => $dishData) {
                if(!array_key_exists($dishTypeName,$dishTypeSelect)){
                    $dishTypeSelect[$dishTypeName] = array();
                }
                if($dishTypeName === $dishData->dishTypeName){
                  $dishTypeSelect[$dishTypeName][$dishData->dish_id] = $dishData->dishName;
                }
            }
        }
        return view('admin.weeklyMenu.weeklyMenuAdd', ['menuArray' => $menuArray,'dishTypeSelect' => $dishTypeSelect,'dayList' => $dayList,'orderTypeData'=>$orderTypeData]);
    }

    public function index()
    {
      // $menuArray = self::getTotalWeekData();
      // return view('admin.weeklyMenu.weeklyMenuAdd', ['menuArray' => json_encode($menuArray)]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_type_id' => 'required',
            'dish' => 'required',
            'day' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $dayId = $request->input('day');
            $day = ucfirst(config('constants.days')[$dayId]);
            $orderTypeId = $request->input('order_type_id');
            DB::table('weekly_dish_lists')->where(['day'=>$day,'order_type_id'=>$orderTypeId])->delete();

            $dish_ids = $request->input('dish');
            foreach($dish_ids as $dishId) {
                $weeklyMenuObj = new WeeklyDishList;
                $weeklyMenuObj->order_type_id = $orderTypeId;
                $weeklyMenuObj->day = $day;
                $weeklyMenuObj->dish_id = $dishId;
                $weeklyMenuObj->save();
                DB::commit();
            }
            return redirect()->route('admin-menu-add')->with('status', 'Weekly Menu added successfully!');
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
                WeeklyDishList::destroy($id);
                return redirect()->back()->with('status', 'Weekly Menu deleted successfully!');
            } catch (Exception $e) {

            }
        }
        return redirect()->back()->withErrors('Something went wrong. Please try again.');
    }

    public function getTotalWeekData()
    {
        $menuArray = array();
        $weeklyMenu = DB::table('weekly_dish_lists')
                ->select("day","order_types.name as orderType","dishes.name as dish","dish_types.name as dishType")
                ->leftjoin("order_types","order_types.id","=","weekly_dish_lists.order_type_id")
                ->leftjoin("dishes","dishes.id","=","weekly_dish_lists.dish_id")
                ->leftjoin("dish_types","dish_types.id","=","dishes.dish_type_id")
                ->orderBy("day","ASC")
                ->get();

        if(!empty($weeklyMenu)){
            foreach($weeklyMenu as $menu){
                if(!array_key_exists($menu->day,$menuArray)){
                    $menuArray[$menu->day] = array();
                    $menuArray[$menu->day][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->orderType,$menuArray[$menu->day])) {
                    $menuArray[$menu->day][$menu->orderType] = array();
                }
                if(!array_key_exists($menu->dishType,$menuArray[$menu->day][$menu->orderType])) {
                    $menuArray[$menu->day][$menu->orderType][$menu->dishType] = array();
                }
                array_push($menuArray[$menu->day][$menu->orderType][$menu->dishType],$menu->dish);
            }
        }
        return $menuArray;
    }

}
