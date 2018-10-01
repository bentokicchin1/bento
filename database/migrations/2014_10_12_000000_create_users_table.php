<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_number');
            $table->enum('billing_cycle',['daily', 'monthly'])->default(NULL);
            $table->enum('food_preference',['veg', 'nonveg'])->default(NULL);
            $table->enum('tiffin_quantity',['full','half'])->default(NULL);
            $table->string('password');
            $table->boolean('mobile_verified')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
