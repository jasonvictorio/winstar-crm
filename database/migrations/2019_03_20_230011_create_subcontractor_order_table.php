<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcontractorOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontractor_order', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('subcontractor_id')->references('id')->on('subcontractors');
            $table->integer('product_id')->references('id')->on('product');
            $table->integer('company_id')->references('id')->on('companies');
            $table->date('date_placed');
            $table->String('status')->references('id')->on('status');
            $table->String('user_id')->references('id')->on('user');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcontractor_order');
    }
}
