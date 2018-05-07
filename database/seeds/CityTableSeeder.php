<?php

use Illuminate\Database\Seeder;
use App\Model\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
          ['name' => 'Navi Mumbai']
      ];
      foreach($data as $val){
          City::create($val);
      }
    }
}
