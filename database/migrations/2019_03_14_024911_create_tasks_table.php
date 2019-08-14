<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('task_description');
            $table->integer('task_type_id')->unsigned();
            $table->foreign('task_type_id')->references('id')->on('task_type');
            $table->integer('task_category_id')->unsigned();
            $table->foreign('task_category_id')->references('id')->on('task_category');
            $table->date('created_date');
            $table->date('deadline_date');
            $table->integer('estimated_duration');
            $table->string('priority_level');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status');
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
        Schema::dropIfExists('tasks');
    }
}
