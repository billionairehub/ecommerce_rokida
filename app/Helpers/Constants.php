<?php
namespace App\Helpers;

class Constants
{
    const PLATFORM_ID = 'WEB';
    const VERSION = '1.0';
    const CHANNEL = 1;
    
    const REQUIRED_DATA_FIELD_PRODUCT = ['name', 'price', 'thumb', 'image', 'categories', 'amount', 'location', 'status', 'book', 'shipping_channels', 'weight', 'length', 'width', 'height'];
    const REQUIRED_DATA_FIELD_PROMOTION = ['pro_from', 'pro_to', 'pro_price'];
    const REQUIRED_DATA_FIELD_TYPE_SHIPPING = ['shipping_channels', 'weight', 'length', 'width', 'height'];
}