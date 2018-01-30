<?php

use Illuminate\Database\Seeder;
use App\Http\Model\DishType;

class DishTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [['name' => 'Sabji'], ['name' => 'Chapati'], ['name' => 'Milk'], ['name' => 'Rice'], ['name' => 'Dal']];
        foreach($data as $val){
            DishType::create($val);
        }
    }
}
