<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->increments('id');
            $table->date('begin')->comment('thời gian bắt đầu');
            $table->date('finish')->comment('thời gian kết thúc');
            $table->integer('detail_product_id')->unsigned()->comment('sản phẩm bảo hành');
            $table->integer('customer_id')->unsigned()->comment('khách hàng');
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
        Schema::dropIfExists('warranties');
    }
}
