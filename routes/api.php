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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

function createApiRoute ($route, $controller) {
    return [
        Route::get($route.'/all', $controller.'@all'),
        Route::apiResource($route, $controller),
    ];
}

createApiRoute('companies', 'API\CompaniesController');
createApiRoute('users', 'API\UsersController');
createApiRoute('status', 'API\StatusController');
