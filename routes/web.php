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
  Route::view('/users', 'users')->name('users');
  Route::view('/companies', 'companies')->name('companies');
  Route::view('/status', 'status')->name('status');
  Route::view('/status-types', 'statustype')->name('statusTypes');
});
