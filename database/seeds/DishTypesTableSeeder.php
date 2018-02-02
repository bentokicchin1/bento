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
        $data = [
            ['name' => 'Sabji'],
            ['name' => 'Chapati'],
            ['name' => 'Rice'],
            ['name' => 'Dal'],
            ['name' => 'Others'],
        ];
        foreach($data as $val){
            DishType::create($val);
        }
    }
}
