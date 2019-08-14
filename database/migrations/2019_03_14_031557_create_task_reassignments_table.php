<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskReassignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_reassignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->string('reason');
            $table->integer('previous_user_id')->unsigned();
            $table->foreign('previous_user_id')->references('id')->on('users');
            $table->integer('current_user_id')->unsigned();
            $table->foreign('current_user_id')->references('id')->on('users');
            $table->date('date_time');
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
        Schema::dropIfExists('task_reassignments');
    }
}
