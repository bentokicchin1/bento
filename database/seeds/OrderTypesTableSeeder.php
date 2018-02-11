<?php

use Illuminate\Database\Seeder;
use App\Model\OrderType;

class OrderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [['name' => 'breakfast'], ['name' => 'lunch'], ['name' => 'dinner']];
        foreach($data as $val){
            OrderType::create($val);
        }
    }
}
