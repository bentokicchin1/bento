<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Anil Gupta','email' => 'anilpgupta@gmail.com', 'mobile_number' => '9029710143', 'password' => bcrypt('123456')]
        ];
        foreach($data as $val){
            User::create($val);
        }
    }
}
