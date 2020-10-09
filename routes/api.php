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

    Route::post('login-account',[
        'as'=>'login-account',
        'uses'=> 'API\LoginController@login'
    ]);
Route::middleware(['assign.guard:api','jwt.auth'])->group(function(){  
    Route::get('get-info-account',[
        'as'=>'get-info-account',
        'uses'=> 'Api\LoginController@getInfo'
    ]);
    Route::get('logout-account',[
        'as'=>'logout-account',
        'uses'=> 'Api\LoginController@logout'
    ]);
});