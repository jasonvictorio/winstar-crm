<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('product_category_id')->unsigned();
            $table->foreign('product_category_id')->references('id')->on('product_category');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->String('product_name');
            $table->Integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
