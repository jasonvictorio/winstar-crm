<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function () {
  Route::view('/', 'home')->name('home');
  Route::view('/user', 'user')->name('user');
  Route::view('/company', 'company')->name('company');
  Route::view('/status', 'status')->name('status');
  Route::view('/nature-of-contact', 'natureofcontact')->name('natureOfContact');
  Route::view('/customer', 'customer')->name('customer');
  Route::view('/project', 'project')->name('project');
  Route::view('/task-type', 'tasktype')->name('taskType');
  Route::view('/task', 'task')->name('task');
  Route::view('/task-category', 'taskcategory')->name('taskCategory');
  Route::view('/chart', 'chart')->name('chart');
});
