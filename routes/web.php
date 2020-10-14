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
            'uses'=> 'Seller\ProductController@store'
        ]);
        Route::get('delete-product/{id}',[
            'as'=>'delete-product',
            'uses'=> 'Seller\ProductController@destroy'
        ]);
        Route::post('update-product/{id}',[
            'as'=>'update-product',
            'uses'=> 'Seller\ProductController@update'
        ]);
        Route::get('hidden-product/{id}',[
            'as'=>'hidden-product',
            'uses'=> 'Seller\UnlistedController@updateHidden'
        ]);
        Route::get('show-product/{id}',[
            'as'=>'show-product',
            'uses'=> 'Seller\UnlistedController@updateShow'
        ]);
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Seller\ProductController@index'
            ]);
            Route::get('active',[
                'as'=>'active',
                'uses'=> 'Seller\ProductController@index'
            ]);
            Route::get('soldout',[
                'as'=>'soldout',
                'uses'=> 'Seller\ProductController@soldout'
            ]);
            Route::get('unlisted',[
                'as'=>'unlisted',
                'uses'=> 'Seller\UnlistedController@index'
            ]);
            Route::group(['prefix' => 'banded'], function () {
                Route::get('action',[
                    'as'=>'action',
                    'uses'=> 'Seller\ProductBandedController@action'
                ]);
                Route::get('history',[
                    'as'=>'history',
                    'uses'=> 'Seller\ProductBandedController@index'
                ]);
            });
        });
    });
    Route::group(['prefix' => 'shipping'], function () {
        Route::post('add-shipping',[
            'as'=>'add-shipping',
            'uses'=> 'Seller\ShippingController@store'
        ]);
        Route::get('delete-shipping',[
            'as'=>'delete-shipping',
            'uses'=> 'Seller\ShippingController@destroy'
        ]);
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Seller\ShippingController@index'
            ]);
        });
    });
    Route::group(['prefix' => 'promotion'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Seller\PromotionController@index'
            ]);
        });
        Route::post('add-promotion',[
            'as'=>'add-promotion',
            'uses'=> 'Seller\PromotionController@store'
        ]);
        Route::get('delete-promotion/{id}',[
            'as'=>'delete-promotion',
            'uses'=> 'Seller\PromotionController@destroy'
        ]);
        Route::get('delete',[
            'as'=>'delete',
            'uses'=> 'Seller\PromotionController@delete'
        ]);
    });
    Route::group(['prefix' => 'classify'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Seller\CLassifyController@index'
            ]);
        });
        Route::post('add-classify',[
            'as'=>'add-classify',
            'uses'=> 'Seller\CLassifyController@store'
        ]);
        Route::post('edit-classify/{id}',[
            'as'=>'edit-classify',
            'uses'=> 'Seller\CLassifyController@update'
        ]);
        Route::get('delete-classify/{id}',[
            'as'=>'delete-classify',
            'uses'=> 'Seller\CLassifyController@destroy'
        ]);
        Route::get('delete',[
            'as'=>'delete',
            'uses'=> 'Seller\CLassifyController@delete'
        ]);
    });
    Route::group(['prefix' => 'sale'], function () {
        Route::get('all', [
            'as' => 'all',
            'uses' => 'Seller\OrderController@index'
        ]);
        Route::get('returnlist', [
            'as' => 'returnlist',
            'uses' => 'Seller\OrderController@return'
        ]);
    });
    Route::group(['prefix' => 'finance'], function () {
        Route::group(['prefix' => 'wallet'], function () {
            Route::group(['prefix' => 'cards'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\BankAccountController@index'
                ]);
                Route::get('card/{id}', [
                    'as' => 'card',
                    'uses' => 'Seller\BankAccountController@show'
                ]);
                Route::post('add-card', [
                    'as' => 'add-card',
                    'uses' => 'Seller\BankAccountController@store'
                ]);
                Route::get('delete-card/{id}', [
                    'as' => 'delete-card',
                    'uses' => 'Seller\BankAccountController@destroy'
                ]);
                Route::get('change-default/{id}', [
                    'as' => 'change-default',
                    'uses' => 'Seller\BankAccountController@changeDefault'
                ]);
            });
        });
        Route::group(['prefix' => 'income'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\RevenueController@index'
            ]);
            Route::get('will-pay', [
                'as' => 'will-pay',
                'uses' => 'Seller\RevenueController@willpay'
            ]);
            Route::get('paid', [
                'as' => 'will-pay',
                'uses' => 'Seller\RevenueController@paid'
            ]);
        });
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'shop'], function () {
            Route::get('rating', [
                'as' => 'rating',
                'uses' => 'Seller\RateReviewShopController@index'
            ]);
            Route::post('reply-review/{id}', [
                'as' => 'reply-review',
                'uses' => 'Seller\RateReviewShopController@store'
            ]);
            Route::get('shop-ratting', [
                'as' => 'shop-ratting',
                'uses' => 'Seller\RateReviewShopController@shopRatting'
            ]);
            Route::group(['prefix' => 'profile'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\ProfileShopController@index'
                ]);
                Route::post('/', [
                    'as' => '/',
                    'uses' => 'Seller\ProfileShopController@update'
                ]);
            });
        });
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [
            'as' => '/',
            'uses' => 'Seller\ShopCategoryController@index'
        ]);
        Route::get('/{id}', [
            'as' => '/',
            'uses' => 'Seller\ShopCategoryController@show'
        ]);
        Route::post('/{id}', [
            'as' => '/',
            'uses' => 'Seller\ShopCategoryController@addProduct'
        ]);
        Route::post('add-category', [
            'as' => 'add-category',
            'uses' => 'Seller\ShopCategoryController@store'
        ]);
        Route::post('edit-category/{id}', [
            'as' => 'edit-category',
            'uses' => 'Seller\ShopCategoryController@update'
        ]);
        Route::get('delete-category/{id}', [
            'as' => 'delete-category',
            'uses' => 'Seller\ShopCategoryController@destroy'
        ]);
        Route::get('show-category/{id}', [
            'as' => 'show-category',
            'uses' => 'Seller\ShopCategoryController@showCategory'
        ]);
        Route::get('hide-category/{id}', [
            'as' => 'hide-category',
            'uses' => 'Seller\ShopCategoryController@hideCategory'
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
