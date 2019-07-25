<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_reminder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->references('id')->on('tasks');
            $table->date('remind_date_time');
            $table->string('subject');
            $table->integer('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_reminder');
    }
}
