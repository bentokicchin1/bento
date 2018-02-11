<?php

use Illuminate\Database\Seeder;
use App\Model\Dish;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = [
        //     ['dish_type_id' => 1, 'order_type_id' => 1, 'name' => 'Aloo', 'code' => 'ALOO', 'price' => 30],
        //     ['dish_type_id' => 1, 'order_type_id' => 1, 'name' => 'Bhendi', 'code' => 'BHENDI', 'price' => 40],
        //     ['dish_type_id' => 1, 'order_type_id' => 1, 'name' => 'Tomato', 'code' => 'TOMATO', 'price' => 25],
        //     ['dish_type_id' => 1, 'order_type_id' => 1, 'name' => 'Palak Paneer', 'code' => 'PALAK_PANEER', 'price' => 60],
        //     ['dish_type_id' => 2, 'order_type_id' => 1, 'name' => 'Chapati', 'code' => 'CHAPATI', 'price' => 5],
        //     ['dish_type_id' => 2, 'order_type_id' => 1, 'name' => 'Roti', 'code' => 'ROTI', 'price' => 7],
        //     ['dish_type_id' => 2, 'order_type_id' => 1, 'name' => 'Bhakri', 'code' => 'BHAKRI', 'price' => 10],
        //     ['dish_type_id' => 3, 'order_type_id' => 1, 'name' => 'Plain Rice', 'code' => 'PLAINRICE', 'price' => 20],
        //     ['dish_type_id' => 3, 'order_type_id' => 1, 'name' => 'Jira Rice', 'code' => 'JIRARICE', 'price' => 25],
        //     ['dish_type_id' => 3, 'order_type_id' => 1, 'name' => 'Pulav', 'code' => 'PULAV', 'price' => 30],
        //     ['dish_type_id' => 4, 'order_type_id' => 1, 'name' => 'Plain Dal', 'code' => 'P_DAL', 'price' => 20],
        //     ['dish_type_id' => 4, 'order_type_id' => 1, 'name' => 'Dal Tadka', 'code' => 'T_DAL', 'price' => 25],
        //     ['dish_type_id' => 4, 'order_type_id' => 1, 'name' => 'Dal Fry', 'code' => 'F_DAL', 'price' => 40],
        //     ['dish_type_id' => 5, 'order_type_id' => 1, 'name' => 'Salad', 'code' => 'SALAD', 'price' => 10],
        //     ['dish_type_id' => 5, 'order_type_id' => 1, 'name' => 'Butter Milk', 'code' => 'B_MILK', 'price' => 10],
        //     // ['dish_type_id' => 5, 'order_type_id' => 1, 'name' => 'Tomato Chatni', 'code' => 'SALAD', 'price' => 10]
        // ];

        $data = [
            ['dish_type_id' => 1, 'name' => 'Aloo', 'code' => 'ALOO', 'price' => 30],
            ['dish_type_id' => 1, 'name' => 'Bhendi', 'code' => 'BHENDI', 'price' => 40],
            ['dish_type_id' => 1, 'name' => 'Tomato', 'code' => 'TOMATO', 'price' => 25],
            ['dish_type_id' => 1, 'name' => 'Palak Paneer', 'code' => 'PALAK_PANEER', 'price' => 60],
            ['dish_type_id' => 2, 'name' => 'Chapati', 'code' => 'CHAPATI', 'price' => 5],
            ['dish_type_id' => 2, 'name' => 'Roti', 'code' => 'ROTI', 'price' => 7],
            ['dish_type_id' => 2, 'name' => 'Bhakri', 'code' => 'BHAKRI', 'price' => 10],
            ['dish_type_id' => 3, 'name' => 'Plain Rice', 'code' => 'PLAINRICE', 'price' => 20],
            ['dish_type_id' => 3, 'name' => 'Jira Rice', 'code' => 'JIRARICE', 'price' => 25],
            ['dish_type_id' => 3, 'name' => 'Pulav', 'code' => 'PULAV', 'price' => 30],
            ['dish_type_id' => 4, 'name' => 'Plain Dal', 'code' => 'P_DAL', 'price' => 20],
            ['dish_type_id' => 4, 'name' => 'Dal Tadka', 'code' => 'T_DAL', 'price' => 25],
            ['dish_type_id' => 4, 'name' => 'Dal Fry', 'code' => 'F_DAL', 'price' => 40],
            ['dish_type_id' => 5, 'name' => 'Salad', 'code' => 'SALAD', 'price' => 10],
            ['dish_type_id' => 5, 'name' => 'Butter Milk', 'code' => 'B_MILK', 'price' => 10],
        ];
        
        foreach($data as $val){
            Dish::create($val);
        }
    }
}
