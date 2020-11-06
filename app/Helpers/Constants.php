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
    const DATA_FIELD_CATEGORY_IMAGE = ['image_category', 'name_category', 'url_category'];
    const DATA_FIELD_DECORATION = ['id_category_shop', 'id_promotion'];
    const REQURED_DATA_FIELD_BANNERS = ['image_banner','content_banner','url_banner', 'type_banner', 'name_banner'];
    const DATA_FIELD_ADDRESS = ['full_name', 'address', 'district', 'province', 'city', 'default', 'pickup', 'return'];
    const REQUIRED_DATA_FIELD_VOUCHER = ['code', 'name', 'code_type', 'time_start',	'time_end',	'voucher_type','discount_type', 'reduction', 'minimum_order_value', 'amount', 'display', 'product'];
    const REQUIRED_DATA_FIELD_DISCOUNT = ['name', 'time_start', 'time_end'];
    const REQUIRED_DATA_FIELD_BUNDLE = ['name', 'time_start', 'time_end', 'type_bundle', 'minimum_order_value', 'order_limit', 'reduction', 'product'];
    const REQUIRED_DATA_FIELD_FOLLOW_PRIZZE = ['name', 'time_start', 'time_end', 'voucher_type', 'discount_type', 'reduction', 'minimum_order_value', 'amount'];
    const REQUIRED_DATA_FIELD_HOTSALE = ['name', 'product'];

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

    const LANGUAGE = ['vi', 'en'];

    const PROMOTION_STATUS_ALL = 0;
    const PROMOTION_STATUS_UPCOMING = 1;
    const PROMOTION_STATUS_HAPPENNING = 2;
    const PROMOTION_STATUS_FINISHED = 3;

    const VOUCHER = 1;
    const DISCOUNT = 2;
    const BUNDLE = 3;
    const FOLLOW_PRIZZE = 4;

    const TYPE_BUNDLE_DISCOUNT_PER_PERCENT = 1;
    const DISCOUNT_BY_AMOUNT = 2;
    const SPECIAL_SALE = 3;
    const TOP_PRODUCT = 5;

    // Endpoint General
    const LIST_ALL_PRODUCT = 'all';
    const LIST_SOLDOUT = 'soldout';
    const PRODUCT_UNLISTED = 'unlisted';
    const BANDED_PRODUCT = 'action';
    const HISTORY_BANDED_PRODUCT = 'history';
}