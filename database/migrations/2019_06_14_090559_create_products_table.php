<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(1)->comments('1 là hot 0 là không hot');
            $table->integer('sale')->default(0)->comments('Giảm giá theo %');
            $table->integer('price');
            $table->integer('category_id');
            $table->integer('quantity');
            $table->string('description')->nullbale();
            $table->longText('content')->nullbale();
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('brand_id');
            $table->integer('view_count')->default(0);
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
        Schema::dropIfExists('products');
    }
}
