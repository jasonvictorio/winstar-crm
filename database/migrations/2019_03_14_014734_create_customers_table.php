<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->references('id')->on('companies');
            $table->date('next_follow_up_date');
            $table->string('latest_contact_or_actions');
            $table->string('nature_of_contact');
            $table->string('notes');
            $table->date('first_contacted');
            $table->date('last_contacted');
            $table->integer('days_since_last_contact');
            $table->integer('status_id')->references('id')->on('status');
            $table->string('month_ordered');
            $table->string('package_ordered');
            $table->string('hear_about_us');
            $table->integer('up_sell');
            $table->integer('quote_total');
            $table->string('addons');
            $table->integer('total');
            $table->integer('invoiced');
            $table->date('annual_renewal_date');
            $table->integer('annual_renewal_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
