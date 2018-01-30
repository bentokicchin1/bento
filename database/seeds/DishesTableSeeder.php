<?php

use Illuminate\Database\Seeder;
use App\Http\Model\Dish;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['dish_type_id' => 1, 'name' => 'Aloo', 'code' => 'ALOO', 'price' => 30],
            ['dish_type_id' => 1, 'name' => 'Bhendi', 'code' => 'BHENDI', 'price' => 40],
            ['dish_type_id' => 1, 'name' => 'Tomato', 'code' => 'ALOO', 'price' => 25],
            ['dish_type_id' => 1, 'name' => 'Palak Paneer', 'code' => 'PALAK_PANEER', 'price' => 60],
            ['dish_type_id' => 3, 'name' => 'Butter Milk', 'code' => 'BMILK', 'price' => 10],
            ['dish_type_id' => 4, 'name' => 'Rice', 'code' => 'BHENDI', 'price' => 20],
            ['dish_type_id' => 5, 'name' => 'Dal', 'code' => 'ALOO', 'price' => 20]
        ];
        
        foreach($data as $val){
            Dish::create($val);
        }
    }
}
