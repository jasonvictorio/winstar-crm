<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

function createApiRoute ($route, $controller) {
    return [
        Route::get($route.'/all', $controller.'@all'),
        Route::get($route.'/report', $controller.'@report'),
        Route::get($route, $controller.'@index'),
        Route::post($route, $controller.'@store'),
        Route::put($route.'/{id}', $controller.'@update'),
        Route::get($route.'/{id}', $controller.'@show'),
        Route::delete($route.'/{id}', $controller.'@destroy'),
    ];
}

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    createApiRoute('company', 'API\CompanyController');
    createApiRoute('user', 'API\UserController');
    createApiRoute('role', 'API\RoleController');
    createApiRoute('status', 'API\StatusController');
    createApiRoute('customer', 'API\CustomerController');
    createApiRoute('customer', 'API\CustomerController');
    createApiRoute('project', 'API\ProjectController');
    createApiRoute('task-category', 'API\TaskCategoryController');
    createApiRoute('task', 'API\TaskController');
});


Route::get('/company/all', 'API\CompanyController@all');
