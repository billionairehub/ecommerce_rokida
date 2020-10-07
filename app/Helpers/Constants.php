<?php
namespace App\Helpers;

class Constants
{
    const PLATFORM_ID = 'WEB';
    const VERSION = '1.0';
    const CHANNEL = 1;
    
    const REQUIRED_DATA_FIELD_USER = ['first_name', 'last_name', 'password', 'phone'];
    const DATA_FIELD_USER = ['email','password', 'first_name', 'last_name', 'avatar', 'gender', 'shop_name', 'city', 'state', 'zip', 'birthday'];
    const REQUIRED_LOGIN = ['username', 'email', 'phone'];
    const REQUIRED_DATA_FIELD_PHONE = ['phone'];
    const REQUIRED_DATA_FIELD_CLASSIFY = ['classify_key', 'classify_value'];
    const REQUIRED_DATA_FIELD_PRODUCT = ['name', 'price', 'thumb', 'image', 'categories', 'amount', 'location', 'status', 'book'];
    const NOT_REQUIRED_DATA_FIELD_PRODUCT = ['sku', 'long_desc', 'short_desc', 'promotion_code', 'trademark', 'made', 'model', 'user_manual', 'img_user_manual'];
    const REQUIRED_DATA_FIELD_PROMOTION = ['pro_from', 'pro_to', 'pro_price'];
    const DATA_FIELD_PROMOTION = ['pro_from', 'pro_to', 'pro_price', 'expired_time'];
    const REQUIRED_DATA_FIELD_TYPE_SHIPPING = ['shipping_channels', 'weight', 'length', 'width', 'height'];

    const OFFSET = 0;
    const LIMIT = 15;

    const STOCK_MIN = 0;
    const STOCK_MAX = 10000;
    const SOLD_MIN = 0;
    const SOLD_MAX = 10000;
}