<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteTable extends Migration
{
    /**
     * Run the migrations.
     * Intentionally not running.
     * 
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('quote', function (Blueprint $table) {
            $table->Increments('id');
            $table->Integer('customer_id')->references('id')->on('customer');
            $table->Integer('quote_item_id')->references('id')->on('quote_item');
            $table->Integer('company_id')->references('id')->on('company');
            $table->Date('date_placed');
            $table->String('status_id')->references('id')->on('status');
            $table->String('quote_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote');
    }
}
