<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(OrderTypesTableSeeder::class);
        $this->call(DishTypesTableSeeder::class);
        $this->call(DishesTableSeeder::class);
        $this->call(CustomerAddressesTableSeeder::class);
        $this->call(WeeklyDishListsTableSeeder::class);
    }
}
