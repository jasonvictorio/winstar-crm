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
        Route::apiResource($route, $controller),
    ];
}

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    createApiRoute('companies', 'API\CompaniesController');
    createApiRoute('users', 'API\UsersController');
    createApiRoute('accesses', 'API\AccessController');
    createApiRoute('status', 'API\StatusController');
    createApiRoute('customers', 'API\CustomerController');
    createApiRoute('status-types', 'API\StatusTypesController');
    createApiRoute('access', 'API\AccessController');
    createApiRoute('nature-of-contact', 'API\NatureOfContactController');
});
