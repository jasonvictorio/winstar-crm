<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('customer_order_id')->unsigned();
            $table->foreign('customer_order_id')->references('id')->on('customer_order');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->date('invoice_date');
            $table->String('payment_method');
            $table->integer('amount_paid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
