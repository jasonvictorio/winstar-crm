<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcontractorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontractor_items', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('subcontractor_order_id')->unsigned();
            $table->foreign('subcontractor_order_id')->references('id')->on('subcontractor_order');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product');
            $table->Integer('price');
            $table->Integer('line_number');
            $table->Integer('invoice_frequency');
            $table->integer('gst_id')->unsigned();
            $table->foreign('gst_id')->references('id')->on('gst');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcontractor_items');
    }
}
