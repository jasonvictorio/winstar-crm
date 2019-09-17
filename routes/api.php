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
    createApiRoute('company', 'API\CompanyController');
    createApiRoute('user', 'API\UserController');
    createApiRoute('access', 'API\AccessController');
    createApiRoute('status', 'API\StatusController');
    createApiRoute('customer', 'API\CustomerController');
    createApiRoute('status-type', 'API\StatusTypeController');
    createApiRoute('nature-of-contact', 'API\NatureOfContactController');
});
