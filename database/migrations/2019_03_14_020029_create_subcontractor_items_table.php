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
            $table->Increments('subcontractor_item_id');
            $table->Integer('subcontractor_order_id')->references('id')->on('subcontractor_order');
            $table->Integer('product_id')->references('id')->on('product');
            $table->Integer('price');
            $table->Integer('line_number');
            $table->Integer('invoice_frequency');
            $table->Integer('gst_amount')->references('id')->on('gst');
            $table->Integer('company_id')->references('id')->on('companies');
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
