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
        $dishTypeSelect = [];

        $daysArray = WeeklyDishList::getDatesForThisWeek();
        $menuArray = WeeklyDishList::getTotalWeekMenuData($daysArray);
        $tableTitle = "Menu from ".date('l, d F',strtotime(reset($daysArray)))." to ".date('l, d F',strtotime(end($daysArray)));
        $orderTypeData = OrderType::pluck('name', 'id');
        $dishTypeData = DishType::pluck('name', 'id');
        $dishes = DB::table('dishes')
                ->select("dishes.id as dish_id", "dishes.name as dishName", "dish_types.id as dish_type_id", "dish_types.name as dishTypeName")
                ->join("dish_types","dish_types.id","=","dishes.dish_type_id")
                ->where('dishes.deleted_at',null)
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

        return view('admin.weeklyMenu.weeklyMenuAdd', ['menuArray' => $menuArray,'dishTypeSelect' => $dishTypeSelect,'orderTypeData'=>$orderTypeData,"tableTitle"=>$tableTitle]);
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
            'menuDate' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $menuDate = $request->input('menuDate');
            $default = $request->input('default');
            $date = date('Y-m-d',strtotime($menuDate));
            $day = ucfirst(date('l',strtotime($menuDate)));
            $orderTypeId = $request->input('order_type_id');

            DB::table('weekly_dish_lists')->where(['date'=>$date,'order_type_id'=>$orderTypeId])->delete();

            $dish_ids = $request->input('dish');
            foreach($dish_ids as $dishId) {
                $weeklyMenuObj = new WeeklyDishList;
                $dishType = Dish::where('id', $dishId)->with('dishType')->first();
                $dishTypeName = $dishType['dishtype']['name'];
                if(array_key_exists($dishTypeName,$default)){
                    if($default[$dishTypeName]==$dishId){
                      $weeklyMenuObj->is_default = 'Y';
                    }else{
                      $weeklyMenuObj->is_default = 'N';
                    }
                }
                $weeklyMenuObj->order_type_id = $orderTypeId;
                $weeklyMenuObj->date = $date;
                $weeklyMenuObj->day = $day;
                $weeklyMenuObj->dish_id = $dishId;
                $weeklyMenuObj->save();
            }
            DB::commit();
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


}
