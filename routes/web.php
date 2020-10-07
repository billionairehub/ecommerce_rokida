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
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'ShippingController@index'
            ]);
        });
    });
    Route::group(['prefix' => 'promotion'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'PromotionController@index'
            ]);
        });
        Route::post('add-promotion',[
            'as'=>'add-promotion',
            'uses'=> 'PromotionController@store'
        ]);
        Route::get('delete-promotion/{id}',[
            'as'=>'delete-promotion',
            'uses'=> 'PromotionController@destroy'
        ]);
        Route::get('delete',[
            'as'=>'delete',
            'uses'=> 'PromotionController@delete'
        ]);
    });
    Route::group(['prefix' => 'classify'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'CLassifyController@index'
            ]);
        });
        Route::post('add-classify',[
            'as'=>'add-classify',
            'uses'=> 'CLassifyController@store'
        ]);
        Route::post('edit-classify/{id}',[
            'as'=>'edit-classify',
            'uses'=> 'CLassifyController@update'
        ]);
        Route::get('delete-classify/{id}',[
            'as'=>'delete-classify',
            'uses'=> 'CLassifyController@destroy'
        ]);
        Route::get('delete',[
            'as'=>'delete',
            'uses'=> 'CLassifyController@delete'
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

Route::group(['prefix' => 'customer'], function () {
    Route::get('{slug}',[
        'as' => 'get-detail-product',
        'uses' => 'Customer\DetailProController@getdetailPro'
    ]);
});
