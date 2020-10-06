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
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [
        'as' => 'register',
        'uses' => 'UserController@store'
    ]);
});
//add-category
Route::post('add-category', [
    'as' => 'add-category',
    'uses' => 'CategoriesController@store'
]);
//update-category
Route::post('update-category/{id}', [
    'as' => 'update-category',
    'uses' => 'CategoriesController@update'
]);
//update-category
Route::post('delete-category/{id}', [
    'as' => 'delete-category',
    'uses' => 'CategoriesController@destroy'
]);
