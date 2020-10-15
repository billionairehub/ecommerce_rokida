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
});


Route::group(['prefix' => 'user'], function () {
    Route::post('register', [
        'as' => 'register',
        'uses' => 'UserController@store'
    ]);
});
//*****CUSTOMER
Route::get('get-detail-product/{slug}',[
        'as' => 'get-detail-product',
        'uses' => 'Customer\DetailProController@getdetailPro'
]);
//order confirm (Xác nhận đơn hàng)
// Route::post('order-confirmation',[
//         'as' => 'order-confirmation',
//         'uses' => 'Customer\OrderController@OderProducts'
// ]);

//get same product of shop
Route::get('same-products-shop/{slug}',[
    'as' => 'same-products-shop',
    'uses' => 'Customer\OrderController@SameProductOfShop'
]);
//get all same products
Route::get('same-products/{slug}',[
    'as' => 'same-products',
    'uses' => 'Customer\OrderController@SameProducts'
]);
//get products just for you
Route::get('products-just-for-you',[
    'as' => 'products-just-for-you',
    'uses' => 'Customer\OrderController@ProductsJustForYou'
]);
//get salling product 
Route::get('selling-products',[
    'as' => 'selling-products',
    'uses' => 'Customer\OrderController@SaleProducts'
]);
//get product viewing history
Route::get('history-view-products',[
    'as' => 'history-view-products',
    'uses' => 'Customer\OrderController@HistoryProduct'
]);
//get cookies 
Route::get('get-cookies',[
    'as' => 'get-cookies',
    'uses' => 'Customer\OrderController@getCookie'
]);
//get reviews product 
Route::get('reviews/{slug}',[
    'as' => 'reviews',
    'uses' => 'Customer\RatingController@GetRateProduct'
]);

//get all categories parent
Route::get('get-all-categories',[
    'as' => 'get-all-categories',
    'uses' => 'Customer\GetCategoryController@index'
]);
//get deail categories and fillter location, shipping unit, price, status products
Route::get('get-detail-categories/{slug}',[
    'as' => 'get-detail-categories',
    'uses' => 'Customer\GetCategoryController@getDetailCategory'
]);

//get products sale 
Route::get('products-sale', [
    'as' => 'product-sale',
    'uses' => 'Customer\SaleProductController@getSaleProduct'
]);

//search 
Route::get('search', [
    'as' => 'search',
    'uses' => 'Customer\SearchProductController@searchProduct'
]);
//get product top search
Route::get('top-products', [
    'as' => 'top-products',
    'uses' => 'Customer\SearchProductController@TopProducts'
]);
//get top keys search
Route::get('top-keywords', [
    'as' => 'top-keywords',
    'uses' => 'Customer\SearchProductController@TopKeySearch'
]);
//add rate product
Route::post('add-rate-product/{id}', [
    'as' => 'add-rate-product',
    'uses' => 'Customer\RatingController@AddRateProduct'
]);
//update rate product
Route::post('update-rate-product/{id}', [
    'as' => 'update-rate-product',
    'uses' => 'Customer\RatingController@UpdateRateProduct'
]);
//Delete rate
Route::post('delete-rate/{id}', [
    'as' => 'delete-rate',
    'uses' => 'Customer\RatingController@DeleteRate'
]);


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


