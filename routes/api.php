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

Route::group(['prefix' => 'portal'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('list/{param}',[
          'as' => 'list_product',
          'uses' => 'Backend\Seller\ProductController@index',
        ]);
        Route::get('banded/{param}',[
            'as' => 'banded_product',
            'uses' => 'Backend\Seller\ProductBandedController@index',
        ]);
    });
});