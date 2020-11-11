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
        /* List product 
        all / soldout / unlisted
        */
        Route::get('list/{param}',[
          'as' => 'list_product',
          'uses' => 'Backend\Seller\ProductController@index',
        ]);
        /*
        action / history
        */
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
    // **********************************************************************************************************************************
    /*
    //     _______     ___     ___     ___     ___________     ___________     ___     ____   ___      ___________ 
    //    |    ___|   |   |   |   |   |   |   |    ___    |   |    ___    |   |   |   |     \|   |    |    _______|
    //    |   |___    |   |___|   |   |   |   |   |___|   |   |   |___|   |   |   |   |          |    |   |  _____ 
    //    |___    |   |    ___    |   |   |   |    _______|   |    _______|   |   |   |   |\     |    |   | |_    |
    //     ___|   |   |   |   |   |   |   |   |   |           |   |           |   |   |   | \    |    |   |___|   |
    //    |_______|   |___|   |___|   |___|   |___|           |___|           |___|   |___|  \___|    |___________|
    */
    // **********************************************************************************************************************************
    Route::group(['prefix' => 'shipping'], function () {
        Route::post('add-shipping',[
            'as'=>'add-shipping',
            'uses'=> 'Backend\Seller\ShippingController@store'
        ]);
        Route::get('delete-shipping',[
            'as'=>'delete-shipping',
            'uses'=> 'Backend\Seller\ShippingController@destroy'
        ]);
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Backend\Seller\ShippingController@index'
            ]);
        });
    });
    //**********************************************************************************************************************************************
    /*
    //   ___________     ___________     ___________     _____      ______   ___________     ____________    ___     ___________     ____   ___ 
    //  |    ___    |   |    ___    |   |    ___    |   |      \   /      | |    ___    |   |____     ___|  |   |   |    ___    |   |     \|   |
    //  |   |___|   |   |   |___|   |   |   |   |   |   |   |\  \_/  /|   | |   |   |   |        |   |      |   |   |   |   |   |   |          |
    //  |    _______|   |    _     _|   |   |   |   |   |   | \     / |   | |   |   |   |        |   |      |   |   |   |   |   |   |   |\     |
    //  |   |           |   | |   |_    |   |___|   |   |   |  \___/  |   | |   |___|   |        |   |      |   |   |   |___|   |   |   | \    |
    //  |___|           |___| |_____|   |___________|   |___|         |___| |___________|        |___|      |___|   |___________|   |___|  \___|
    */
    //***********************************************************************************************************************************************
    Route::group(['prefix' => 'promotion'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all',[
                'as'=>'all',
                'uses'=> 'Backend\Seller\PromotionController@index'
            ]);
        });
        Route::post('add-promotion',[
            'as'=>'add-promotion',
            'uses'=> 'Backend\Seller\PromotionController@store'
        ]);
        Route::get('delete-promotion/{id}',[
            'as'=>'delete-promotion',
            'uses'=> 'Backend\Seller\PromotionController@destroy'
        ]);
        Route::get('delete/{product}',[
            'as'=>'delete',
            'uses'=> 'Backend\Seller\PromotionController@delete'
        ]);
    });
    //**********************************************************************************************************************************************
    /*
    //   ___________     ___         ___________     _______     _______     ___     _______     ___     ___
    //  |    ___    |   |   |       |    ___    |   |    ___|   |    ___|   |   |   |    ___|   |   |   |   |
    //  |   |   |___|   |   |       |   |___|   |   |   |___    |   |___    |   |   |   |___    |   |___|   |
    //  |   |    ___    |   |       |    ___    |   |___    |   |___    |   |   |   |    ___|   |___     ___|
    //  |   |___|   |   |   |___    |   |   |   |    ___|   |    ___|   |   |   |   |   |           |   |
    //  |___________|   |_______|   |___|   |___|   |_______|   |_______|   |___|   |___|           |___|
    */
    //***********************************************************************************************************************************************
    Route::group(['prefix' => 'classify'], function () {
        Route::group(['prefix' => 'list'], function () {
            Route::get('all/{product}',[
                'as'=>'all',
                'uses'=> 'Backend\Seller\CLassifyController@index'
            ]);
        });
        Route::post('add-classify',[
            'as'=>'add-classify',
            'uses'=> 'Backend\Seller\CLassifyController@store'
        ]);
        Route::post('edit-classify/{id}',[
            'as'=>'edit-classify',
            'uses'=> 'Backend\Seller\CLassifyController@update'
        ]);
        Route::get('delete-classify/{id}',[
            'as'=>'delete-classify',
            'uses'=> 'Backend\Seller\CLassifyController@destroy'
        ]);
        Route::get('delete/{product}',[
            'as'=>'delete',
            'uses'=> 'Backend\Seller\CLassifyController@delete'
        ]);
    });
    //**********************************************************************************************************************************************
    /*
    //   _______     ___________     ___         _______
    //  |    ___|   |    ___    |   |   |       |    ___|
    //  |   |___    |   |___|   |   |   |       |   |___
    //  |___    |   |    ___    |   |   |       |    ___|
    //   ___|   |   |   |   |   |   |   |___    |   |___
    //  |_______|   |___|   |___|   |_______|   |_______|
    */
    //***********************************************************************************************************************************************
    Route::group(['prefix' => 'sale'], function () {
        Route::get('all', [
            'as' => 'all',
            'uses' => 'Backend\Seller\SaleController@index'
        ]);
    });
    //**********************************************************************************************************************************************
    /*
    //   _______     ___     ____   ___      ___________     ____   ___      ___________     _______
    //  |    ___|   |   |   |     \|   |    |    ___    |   |     \|   |    |    ___    |   |    ___|
    //  |   |___    |   |   |          |    |   |___|   |   |          |    |   |   |___|   |   |___
    //  |    ___|   |   |   |   |\     |    |    ___    |   |   |\     |    |   |    ___    |    ___|
    //  |   |       |   |   |   | \    |    |   |   |   |   |   | \    |    |   |___|   |   |   |___
    //  |___|       |___|   |___|  \___|    |___|   |___|   |___|  \___|    |___________|   |_______|
    */
    //***********************************************************************************************************************************************
    Route::group(['prefix' => 'finance'], function () {
        Route::group(['prefix' => 'wallet'], function () {
            Route::group(['prefix' => 'cards'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Backend\Seller\BankAccountController@index'
                ]);
                // Route::get('card/{id}', [
                //     'as' => 'card',
                //     'uses' => 'Seller\BankAccountController@show'
                // ]);
                // Route::post('add-card', [
                //     'as' => 'add-card',
                //     'uses' => 'Seller\BankAccountController@store'
                // ]);
                // Route::get('delete-card/{id}', [
                //     'as' => 'delete-card',
                //     'uses' => 'Seller\BankAccountController@destroy'
                // ]);
                // Route::get('change-default/{id}', [
                //     'as' => 'change-default',
                //     'uses' => 'Seller\BankAccountController@changeDefault'
                // ]);
            });
        });
        // Route::group(['prefix' => 'income'], function () {
        //     Route::get('/', [
        //         'as' => '/',
        //         'uses' => 'Seller\RevenueController@index'
        //     ]);
        //     Route::get('will-pay', [
        //         'as' => 'will-pay',
        //         'uses' => 'Seller\RevenueController@willpay'
        //     ]);
        //     Route::get('paid', [
        //         'as' => 'will-pay',
        //         'uses' => 'Seller\RevenueController@paid'
        //     ]);
        // });
    });
});