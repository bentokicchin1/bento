<?php

use Illuminate\Database\Seeder;
use App\Model\CustomerAddresse;

class CustomerAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['user_id' => 1, 'order_type_id' => 1, 'address_type' => 'Office', 'name' => 'Anil Gupta', 'location' => 'Charms City Complex', 'area' => 'Koperkhairne', 'city' => 'Navi Mumbai', 'state' => 'Maharashtra', 'pincode' => 400078],
        ];
        foreach($data as $val){
            CustomerAddresse::create($val);
        }
    }
}
