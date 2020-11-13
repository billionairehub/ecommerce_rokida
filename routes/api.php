<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    //****************************************************************************************************************************
    /*
    //   ___________     ___________     ___________     _________       ___     ___     ___________     ____________ 
    //  |    ___    |   |    ___    |   |    ___    |   |    ___   \    |   |   |   |   |    ___    |   |____     ___|
    //  |   |___|   |   |   |___|   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |___|        |   |    
    //  |    _______|   |    _     _|   |   |   |   |   |   |   |   |   |   |   |   |   |   |    ___         |   |    
    //  |   |           |   | |   |     |   |___|   |   |   |___|   |   |   |___|   |   |   |___|   |        |   |    
    //  |___|           |___| |___|     |___________|   |__________/    |___________|   |___________|        |___|    
    */
    //****************************************************************************************************************************
    Route::group(['prefix' => 'product'], function () {
        Route::get('list/{param}',[
          'as' => 'list_product',
          'uses' => 'Backend\Seller\ProductController@index',
        ]);
        Route::get('banded/{param}',[
            'as' => 'banded_product',
            'uses' => 'Backend\Seller\ProductBandedController@index',
        ]);
        Route::get('show-hide-product/{id}',[
            'as'=>'show-hide-product',
            'uses'=> 'Backend\Seller\ProductController@showHideProduct'
        ]);
        Route::post('add-product',[
            'as'=>'add-product',
            'uses'=> 'Backend\Seller\ProductController@store'
        ]);
        Route::post('update-product/{id}',[
            'as'=>'update-product',
            'uses'=> 'Backend\Seller\ProductController@update'
        ]);
        Route::get('delete-product/{id}',[
            'as'=>'delete-product',
            'uses'=> 'Backend\Seller\ProductController@destroy'
        ]);
    });
});