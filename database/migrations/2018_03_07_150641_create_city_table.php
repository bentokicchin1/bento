<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
    public function up()
    {
        if (!Schema::hasTable('city')) {
            Schema::create('city', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',50);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
