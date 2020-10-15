<?php
namespace App\Helpers;

class Constants
{
    const PLATFORM_ID = 'WEB';
    const VERSION = '1.0';
    const CHANNEL = 1;
    
    const REQUIRED_DATA_FIELD_USER = ['first_name', 'last_name', 'passwords', 'phone'];
    const DATA_FIELD_USER = ['email','passwords', 'first_name', 'last_name', 'avatar', 'gender', 'shop_name', 'city', 'state', 'zip', 'birthday', 'shop_id'];
    const REQUIRED_LOGIN = ['username', 'email', 'phone'];
    const REQUIRED_DATA_FIELD_PHONE = ['phone'];
    const REQUIRED_DATA_FIELD_CLASSIFY = ['classify_key', 'classify_value'];
    const REQUIRED_DATA_FIELD_PRODUCT = ['name', 'shop_id', 'price', 'thumb', 'image', 'categories', 'amount', 'location', 'status', 'book'];
    const NOT_REQUIRED_DATA_FIELD_PRODUCT = ['sku', 'long_desc', 'short_desc', 'promotion_code', 'trademark', 'made', 'model', 'user_manual', 'img_user_manual', 'promotional_price'];
    const REQUIRED_DATA_FIELD_PROMOTION = ['pro_from', 'pro_to', 'pro_price'];
    const DATA_FIELD_PROMOTION = ['pro_from', 'pro_to', 'pro_price', 'expired_time'];
    const REQUIRED_DATA_FIELD_TYPE_SHIPPING = ['shipping_channels', 'weight', 'length', 'width', 'height'];
    const REQUIRED_DATE_FIELD_TYPE_BANK_ACCOUNT = ['user_name', 'identity_card', 'account_name', 'bank_name', 'account_number', 'area', 'branch'];
    const DATA_FIELD_SHOP = ['shop_name', 'avatar_shop', 'cover_avatar', 'des_image_video', 'description', 'shop_address'];
    const DATA_FIELD_CATEGORY_IMAGE = ['image', 'name', 'url'];
    const DATA_FIELD_DECORATION = ['id_category_shop', 'id_promotion', 'id_image_category_shop'];
    const REQURED_DATA_FIELD_BANNERS = ['url_img','content','url_pro', 'content'];

    const OFFSET = 0;
    const LIMIT = 15;

    const STOCK_MIN = 0;
    const STOCK_MAX = 100000;
    const SOLD_MIN = 0;
    const SOLD_MAX = 100000;

    const WAIT_FOR_CONFIRMATION = 0;
    const WAITING_TO_GET_THE_GOODS = 1;
    const HAS_RECEIVED_THE_GOODS = 2;
    const DELIVERY_IS_IN_PROGRESS = 3;
    const DELIVERED = 4;
    const CANCELED = 5;

    const RETURNS_AND_REFUND_WITHOUT_HANDLING = 0;
    const RETURNS_AND_REFUND_HANDLED = 1;
}