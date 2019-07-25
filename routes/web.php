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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/companies', 'CompaniesController@index')->name('companies');
Route::get('/customers', 'CustomersController@index')->name('customers');
Route::get('/projects', 'ProjectsController@index')->name('projects');
Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::get('/domains', 'DomainsController@index')->name('domains');
Route::get('/project_contacts', 'ProjectContactsController@index')->name('project_contacts');
Route::get('/status', 'StatusController@index')->name('status');
Route::get('/subcontractors', 'SubcontractorsController@index')->name('subcontractors');
Route::get('/tasks', 'TasksController@index')->name('tasks');
Route::get('/task_categories', 'TaskCategoriesController@index')->name('task_categories');
Route::get('/task_reassignments', 'TaskReassignmentsController@index')->name('task_reassignments');
Route::get('/task_reminders', 'TaskRemindersController@index')->name('task_reminders');
Route::get('/task_types', 'TaskTypesController@index')->name('task_types');
Route::get('/timesheets', 'TimesheetsController@index')->name('timesheets');

Route::post('/change_page','CRMGridController@change_page');
Route::post('/postedit','CRMGridController@edit');
Route::post('/posteditrow','CRMGridController@edit_row');
Route::post('/get_details','CRMGridController@get_details');
Route::post('/delete', 'CRMGridController@delete');
Route::post('/postsort','CRMGridController@sort');
Route::post('/postadd','CRMGridController@add');

