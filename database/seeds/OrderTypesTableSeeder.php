<?php

use Illuminate\Database\Seeder;
use App\Http\Model\OrderType;

class OrderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('order_types')->insert([
        //     'name' => 'breakfast',
        // ]);
        // DB::table('order_types')->insert([
        //     'name' => 'lunch',
        // ]);
        // DB::table('order_types')->insert([
        //     'name' => 'dinner',
        // ]);

        $data = [['name' => 'Sabji'], ['name' => 'Chapati'], ['name' => 'Milk']];
        foreach($data as $val){
            OrderType::create($val);
        }
    }
}
