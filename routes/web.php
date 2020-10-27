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
            Route::group(['prefix' => 'address'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\AddressController@index'
                ]);
                Route::post('add', [
                    'as' => 'add',
                    'uses' => 'Seller\AddressController@store'
                ]);
                Route::post('update/{id}', [
                    'as' => 'update',
                    'uses' => 'Seller\AddressController@update'
                ]);
                Route::get('set-default/{id}', [
                    'as' => 'set-default',
                    'uses' => 'Seller\AddressController@setDefault'
                ]);
                Route::get('pick-up-address/{id}', [
                    'as' => 'pick-up-address',
                    'uses' => 'Seller\AddressController@pickup'
                ]);
                Route::get('return-address/{id}', [
                    'as' => 'return-address',
                    'uses' => 'Seller\AddressController@return'
                ]);
                Route::get('delete/{id}', [
                    'as' => 'update',
                    'uses' => 'Seller\AddressController@destroy'
                ]);
            });
        });
        Route::group(['prefix' => 'basic'], function () {
            Route::group(['prefix' => 'shop'], function () {
                Route::post('enable-phone-call', [
                    'as' => 'enable-phone-call',
                    'uses' => 'Seller\SettingController@enablePhoneCall'
                ]);
                Route::post('enable-vacation-mode', [
                    'as' => 'enable-vacation-mode',
                    'uses' => 'Seller\SettingController@enableVacationMode'
                ]);
                Route::post('transify-lang', [
                    'as' => 'transify-lang',
                    'uses' => 'Seller\SettingController@transifyLang'
                ]);
            });
            Route::group(['prefix' => 'payment'], function () {
                Route::post('creditcard-payment-enabled', [
                    'as' => 'creditcard-payment-enabled',
                    'uses' => 'Seller\SettingController@creditcardPaymentEnabled'
                ]);
                Route::post('change-payment-password', [
                    'as' => 'change-payment-password',
                    'uses' => 'Seller\SettingController@changePaymentPassword'
                ]);
            });
            Route::group(['prefix' => 'privacy'], function () {
                Route::post('feed-private', [
                    'as' => 'feed-private',
                    'uses' => 'Seller\SettingController@feedPrivate'
                ]);
                Route::post('hide-likes', [
                    'as' => 'hide-likes',
                    'uses' => 'Seller\SettingController@hideLike'
                ]);
                Route::get('block-list', [
                    'as' => 'block-list',
                    'uses' => 'Seller\BlocklistController@index'
                ]);
                Route::get('delete-user-block-list/{id}', [
                    'as' => 'delete-user-block-list/{id}',
                    'uses' => 'Seller\BlocklistController@destroy'
                ]);
            });
            Route::group(['prefix' => 'chat'], function () {
                Route::post('make-offer-status', [
                    'as' => 'make-offer-status',
                    'uses' => 'Seller\SettingController@makeOfferStatus'
                ]);
                Route::post('chat-status', [
                    'as' => 'chat-status',
                    'uses' => 'Seller\SettingController@chatStatus'
                ]);
            });
            Route::group(['prefix' => 'notification'], function () {
                Route::post('enable-email-notifications', [
                    'as' => 'enable-email-notifications',
                    'uses' => 'Seller\SettingController@enableEmailNotifications'
                ]);
                Route::post('enable-order-updates-email', [
                    'as' => 'enable-order-updates-email',
                    'uses' => 'Seller\SettingController@enableOrderUpdatesEmail'
                ]);
                Route::post('enable-newsletter', [
                    'as' => 'enable-newsletter',
                    'uses' => 'Seller\SettingController@enableNewsletter'
                ]);
                Route::post('enable-listing-updates', [
                    'as' => 'enable-listing-updates',
                    'uses' => 'Seller\SettingController@enableListingUpdates'
                ]);
                Route::post('enable-personalised-content', [
                    'as' => 'enable-personalised-content',
                    'uses' => 'Seller\SettingController@enablePersonalisedContent'
                ]);
                // 
                Route::post('enable-push-notifications', [
                    'as' => 'enable-push-notifications',
                    'uses' => 'Seller\SettingController@enablePushNotifications'
                ]);
                Route::post('enable-notifications-by-batch', [
                    'as' => 'enable-notifications-by-batch',
                    'uses' => 'Seller\SettingController@enableNotificationsByBatch'
                ]);
                Route::post('enable-order-updates-push', [
                    'as' => 'enable-order-updates-push',
                    'uses' => 'Seller\SettingController@enableOrderUpdatesPush'
                ]);
                Route::post('enable-chats', [
                    'as' => 'enable-chats',
                    'uses' => 'Seller\SettingController@enableChats'
                ]);
                Route::post('enable-shopee-promotions', [
                    'as' => 'enable-shopee-promotions',
                    'uses' => 'Seller\SettingController@enableShopeePromotions'
                ]);
                Route::post('enable-follows-and-comments', [
                    'as' => 'enable-follows-and-comments',
                    'uses' => 'Seller\SettingController@enableFollowsAndComments'
                ]);
                Route::post('enable-products-sold-out', [
                    'as' => 'enable-products-sold-out',
                    'uses' => 'Seller\SettingController@enableProductsSoldOut'
                ]);
                Route::post('enable-wallet-updates', [
                    'as' => 'enable-wallet-updates',
                    'uses' => 'Seller\SettingController@enableWalletUpdates'
                ]);
            });
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\SettingController@index'
            ]);
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
    Route::group(['prefix' => 'marketing'], function () {
        Route::group(['prefix' => 'vouchers'], function () {
            Route::post('new', [
                'as' => 'new',
                'uses' => 'Seller\VoucherController@store'
            ]);
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\VoucherController@index'
                ]);
                Route::get('dashboard', [
                    'as' => 'dashboard',
                    'uses' => 'Seller\VoucherController@dashboard'
                ]);
            });
        });
        Route::group(['prefix' => 'discount'], function () {
            Route::post('create', [
                'as' => 'create',
                'uses' => 'Seller\DiscountController@store'
            ]);
        });
        Route::group(['prefix' => 'list'], function () {
            Route::group(['prefix' => 'discount'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\DiscountController@index'
                ]);
                Route::get('dashboard', [
                    'as' => 'dashboard',
                    'uses' => 'Seller\DiscountController@dashboard'
                ]);
            });
        });
        Route::group(['prefix' => 'bundle'], function () {
            Route::group(['prefix' => 'new'], function () {
                Route::post('/', [
                    'as' => '/',
                    'uses' => 'Seller\BundleController@store'
                ]);
            });
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\BundleController@index'
                ]);
                Route::get('dashboard', [
                    'as' => 'dashboard',
                    'uses' => 'Seller\BundleController@dashboard'
                ]);
            });
        });
        Route::group(['prefix' => 'follow-prize'], function () {
            Route::group(['prefix' => 'create'], function () {
                Route::post('/', [
                    'as' => '/',
                    'uses' => 'Seller\FollowPrizeController@store'
                ]);
            });
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\FollowPrizeController@index'
                ]);
                Route::get('dashboard', [
                    'as' => 'dashboard',
                    'uses' => 'Seller\FollowPrizeController@dashboard'
                ]);
            });
        });
        Route::group(['prefix' => 'hotsale'], function () {
            Route::group(['prefix' => 'new'], function () {
                Route::post('/', [
                    'as' => '/',
                    'uses' => 'Seller\HotSaleController@store'
                ]);
            });
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [
                    'as' => '/',
                    'uses' => 'Seller\HotSaleController@index'
                ]);
                Route::get('/{id}', [
                    'as' => '/{id}',
                    'uses' => 'Seller\HotSaleController@show'
                ]);
                Route::get('delete/{id}', [
                    'as' => 'delete/{id}',
                    'uses' => 'Seller\HotSaleController@destroy'
                ]);
            });
        });
    });
    Route::group(['prefix' => 'seller-management'], function () {
        Route::get('/', [
            'as' => '/',
            'uses' => 'Seller\FavoriteShopController@index'
        ]);
    });
});
Route::group(['prefix' => 'datacenter'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [
            'as' => '/',
            'uses' => 'Seller\DatacenterController@dashboard'
        ]);
    });
    Route::group(['prefix' => 'products'], function () {
        Route::group(['prefix' => 'overview'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\DatacenterController@productStatisticsOverview'
            ]);
        });
        Route::group(['prefix' => 'performance'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\DatacenterController@productStatisticsPerformance'
            ]);
        });
    });
    Route::group(['prefix' => 'sales'], function () {
        Route::group(['prefix' => 'overview'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\DatacenterController@salesOverview'
            ]);
        });
    });
    Route::group(['prefix' => 'marketing'], function () {
        Route::group(['prefix' => 'discount'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\DiscountController@dashboard'
            ]);
        });
        Route::group(['prefix' => 'bundle'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\BundleController@dashboard'
            ]);
        });
        Route::group(['prefix' => 'prize'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\FollowPrizeController@dashboard'
            ]);
        });
        Route::group(['prefix' => 'voucher'], function () {
            Route::get('/', [
                'as' => '/',
                'uses' => 'Seller\VoucherController@dashboard'
            ]);
        });
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::get('/', [
            'as' => '/',
            'uses' => 'Seller\DatacenterController@chat'
        ]);
    });
});
Route::group(['prefix' => 'decoration'], function () {
    Route::get('/', [
        'as' => '/',
        'uses' => 'Seller\DecorationController@index'
    ]);
    Route::post('/', [
        'as' => '/',
        'uses' => 'Seller\DecorationController@store'
    ]);
    Route::post('/add-banner', [
        'as' => 'add-banner',
        'uses' => 'Seller\BannerController@store'
    ]);
    Route::post('/add-image-category', [
        'as' => 'add-image-category',
        'uses' => 'Seller\ImageCategoryController@store'
    ]);
});
Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => 'selleraccount'], function () {
        Route::post('set_account_settings', [
            'as' => 'set_account_settings',
            'uses' => 'UserController@updateProfile'
        ]);
    });
    Route::post('register', [
        'as' => 'register',
        'uses' => 'UserController@store'
    ]);
    Route::post('login', [
        'as' => 'login',
        'uses' => 'UserController@login'
    ]);
});
