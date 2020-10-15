<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Http\Controllers\Functions\Seller\BannerShops;

use Carbon\Carbon;

use App\Decoration;
use App\ImageCategoryShops;
use App\Shop;
use App\User;

class Decorations {
  public static function addDecoration($userId, $keys, $lst) {
    $decoration = new Decoration;
    // if () {
    //   $success = BannerShops::addBanner($userId, $keys, $lst);
    //   if ($success == -2) {
    //     return false;
    //   } else {
    //     $decoration->id_banner = $success;
    //   }
    // }
    // if (in_array($key, Constants::DATA_FIELD_CATEGORY_IMAGE) == true){ 
    //   $success = BannerShops::addBanner($userId, $keys, $lst);
    //   if ($success == -2) {
    //     return false;
    //   } else {
    //     $decoration->id_image_category_shop = $success;
    //   }
    // }
    // if ($key == 'id_category_shop' || $key == 'id_promotion'){
    //   $decoration->$key = $lst[$key];
    // }
  }
}