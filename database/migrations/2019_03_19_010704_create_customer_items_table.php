<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_items', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('customer_order_id')->unsigned();
            $table->foreign('customer_order_id')->references('id')->on('customer_order');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product');
            $table->Integer('invoice_frequency');
            $table->Integer('price');
            $table->Integer('line_number');
            $table->integer('gst_id')->unsigned();
            $table->foreign('gst_id')->references('id')->on('gst');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('customer_items');
    }
}
