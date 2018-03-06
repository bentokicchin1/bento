<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dish_type_id');
            $table->foreign('dish_type_id')->references('id')->on('dish_types');
            // $table->unsignedInteger('order_type_id');
            // $table->foreign('order_type_id')->references('id')->on('order_types');
            $table->string('name');
            $table->string('code');
            $table->decimal('price',8,2);
            $table->string('description');
            $table->string('image');
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
        Schema::dropIfExists('dishes');
    }
}
