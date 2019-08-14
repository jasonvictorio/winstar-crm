<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->Increments('id');
            $table->Integer('quote_id')->references('id')->on('quote');
            $table->Integer('product_id')->references('id')->on('product');
            $table->Integer('invoice_frequency');
            $table->Integer('price');
            $table->Integer('line number');
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
        Schema::dropIfExists('quote_items');
    }
}
