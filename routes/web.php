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
Route::group(['prefix' => 'portal'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::post('add-product',[
            'as'=>'add-product',
            'uses'=> 'ProductController@store'
        ]);
        Route::get('delete-product/{id}',[
            'as'=>'delete-product',
            'uses'=> 'ProductController@destroy'
        ]);
        Route::post('update-product/{id}',[
            'as'=>'update-product',
            'uses'=> 'ProductController@update'
        ]);
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'ProductController@index'
            ]);
        });
    });
    Route::group(['prefix' => 'shipping'], function () {
        Route::post('add-shipping',[
            'as'=>'add-shipping',
            'uses'=> 'ShippingController@store'
        ]);
        Route::get('delete-shipping',[
            'as'=>'delete-shipping',
            'uses'=> 'ShippingController@destroy'
        ]);
    });
    Route::group(['prefix' => 'promotion'], function () {
        Route::post('add-promotion',[
            'as'=>'add-promotion',
            'uses'=> 'PromotionController@store'
        ]);
        Route::get('delete-promotion',[
            'as'=>'delete-promotion',
            'uses'=> 'PromotionController@destroy'
        ]);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [
        'as' => 'register',
        'uses' => 'UserController@store'
    ]);
    Route::post('login', [
        'as' => 'login',
        'uses' => 'UserController@login'
    ]);
});
