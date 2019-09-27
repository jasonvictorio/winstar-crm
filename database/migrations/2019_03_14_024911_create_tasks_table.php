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
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('created_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->integer('project_id')->unsigned();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('task_type_id')->unsigned()->nullable();
            $table->integer('task_category_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('task_type_id')->references('id')->on('task_types');
            $table->foreign('task_category_id')->references('id')->on('task_categories');
            $table->foreign('user_id')->references('id')->on('users');
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
