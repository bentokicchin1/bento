<?php

use Illuminate\Database\Seeder;
use App\Model\WeeklyDishList;

class WeeklyDishListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['day' => 'Monday', 'dish_id' => 1],
            ['day' => 'Monday', 'dish_id' => 2],
            ['day' => 'Monday', 'dish_id' => 3],
            ['day' => 'Monday', 'dish_id' => 4],
            ['day' => 'Monday', 'dish_id' => 5],
            ['day' => 'Monday', 'dish_id' => 6],
            ['day' => 'Monday', 'dish_id' => 7],
            ['day' => 'Monday', 'dish_id' => 8],
            ['day' => 'Monday', 'dish_id' => 9],
            ['day' => 'Monday', 'dish_id' => 10],
            ['day' => 'Monday', 'dish_id' => 11],
            ['day' => 'Monday', 'dish_id' => 12],
            ['day' => 'Monday', 'dish_id' => 13],
            ['day' => 'Monday', 'dish_id' => 14],
            ['day' => 'Monday', 'dish_id' => 15],
            ['day' => 'Tuesday', 'dish_id' => 1],
            ['day' => 'Tuesday', 'dish_id' => 2],
            ['day' => 'Tuesday', 'dish_id' => 3],
            ['day' => 'Tuesday', 'dish_id' => 4],
            ['day' => 'Tuesday', 'dish_id' => 5],
            ['day' => 'Tuesday', 'dish_id' => 6],
            ['day' => 'Tuesday', 'dish_id' => 7],
            ['day' => 'Wednesday', 'dish_id' => 3],
            ['day' => 'Wednesday', 'dish_id' => 4],
            ['day' => 'Wednesday', 'dish_id' => 5],
            ['day' => 'Wednesday', 'dish_id' => 6],
            ['day' => 'Wednesday', 'dish_id' => 7],
            ['day' => 'Wednesday', 'dish_id' => 8],
            ['day' => 'Wednesday', 'dish_id' => 9],
            ['day' => 'Wednesday', 'dish_id' => 10],
            ['day' => 'Thursday', 'dish_id' => 1],
            ['day' => 'Thursday', 'dish_id' => 2],
            ['day' => 'Thursday', 'dish_id' => 5],
            ['day' => 'Thursday', 'dish_id' => 6],
            ['day' => 'Thursday', 'dish_id' => 7],
            ['day' => 'Thursday', 'dish_id' => 8],
            ['day' => 'Thursday', 'dish_id' => 9],
            ['day' => 'Thursday', 'dish_id' => 14],
            ['day' => 'Thursday', 'dish_id' => 15],
            ['day' => 'Friday', 'dish_id' => 1],
            ['day' => 'Friday', 'dish_id' => 2],
            ['day' => 'Friday', 'dish_id' => 3],
            ['day' => 'Friday', 'dish_id' => 4],
            ['day' => 'Friday', 'dish_id' => 5],
            ['day' => 'Friday', 'dish_id' => 6],
            ['day' => 'Friday', 'dish_id' => 7],
            ['day' => 'Saturday', 'dish_id' => 1],
            ['day' => 'Saturday', 'dish_id' => 2],
            ['day' => 'Saturday', 'dish_id' => 3],
            ['day' => 'Saturday', 'dish_id' => 4],
            ['day' => 'Saturday', 'dish_id' => 5],
            ['day' => 'Saturday', 'dish_id' => 6],
            ['day' => 'Saturday', 'dish_id' => 14],
            ['day' => 'Saturday', 'dish_id' => 15],
            
        ];
        foreach($data as $val){
            WeeklyDishList::create($val);
        }
    }
}
