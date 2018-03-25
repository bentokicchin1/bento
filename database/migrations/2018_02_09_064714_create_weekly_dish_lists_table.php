<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyDishListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_dish_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->date('date');
            $table->unsignedInteger('order_type_id');
            $table->foreign('order_type_id')->references('id')->on('order_types');
            $table->unsignedInteger('dish_id');
            $table->foreign('dish_id')->references('id')->on('dishes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_dish_lists');
    }
}
