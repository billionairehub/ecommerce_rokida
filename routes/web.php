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
    });
});

//create banner
Route::post('create-banner',[
    'as'=>'create-banner',
    'uses'=> 'BannerController@store'
]);
//get banner
Route::get('get-banner',[
    'as'=>'get-banner',
    'uses'=> 'BannerController@index'
]);
//update banner
Route::post('update-banner/{id}',[
    'as'=>'update-banner',
    'uses'=> 'BannerController@update'
]);
//delete banner
Route::post('delete-banner/{id}',[
    'as'=>'delete-banner',
    'uses'=> 'BannerController@destroy'
]);

