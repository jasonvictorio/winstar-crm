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
            $table->Increments('product_id');
            $table->Integer('product_category_id')->references('id')->on('product_category');
            $table->Integer('company_id')->references('id')->on('company');
            $table->String('product_name');
            $table->Integer('price');
            $table->String('unit_of_measure_id')->references('id')->on('unit_of_measure');
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
