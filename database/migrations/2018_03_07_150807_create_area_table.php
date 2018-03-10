<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
    public function up()
    {
        if (!Schema::hasTable('areas')) {
            Schema::create('areas', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('city_id');
                $table->string('name',50);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('city_id')->references('id')->on('city');
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
