<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_mobile');
            $table->integer('status')->unsigned()->default(0);
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('customer_email')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('reason_reject')->nullable();// lý do từ chối
            $table->string('coupon_code')->nullable();// mã giảm giá

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
