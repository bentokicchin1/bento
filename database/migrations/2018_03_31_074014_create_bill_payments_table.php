<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('bill_payments')) {
          Schema::create('bill_payments', function (Blueprint $table) {
              $table->increments('id');
              $table->unsignedInteger('user_id');
              $table->integer('month');
              $table->double('paid_bill',8,2);
              $table->double('outstanding_bill',8,2);
              $table->double('total_bill',8,2);
              $table->date('payment_date');
              $table->enum('mode_of_payment',['cash', 'online_transfer','paytm','card']);
              $table->timestamps();
              $table->softDeletes();
              $table->engine = 'InnoDB';
              $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('bill_payments');
    }
}
