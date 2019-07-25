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
            $table->Increments('item_id');
            $table->Integer('customer_order_id')->references('id')->on('customer_order');
            $table->Integer('product_id')->references('id')->on('product');
            $table->Integer('invoice_frequency');
            $table->Integer('price');
            $table->Integer('line_number');
            $table->Integer('gst_amount')->references('id')->on('gst');
            $table->Integer('company_id')->references('id')->on('company');


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
