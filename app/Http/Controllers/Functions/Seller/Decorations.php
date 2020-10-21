<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Http\Controllers\Functions\Seller\BannerShops;
use App\Http\Controllers\Functions\Seller\ImageCategoryShops;

use Carbon\Carbon;

use App\Models\Decoration;
use App\Models\ImageCategoryShop;
use App\Models\Shop;
use App\Models\User;

class Decorations {
  public static function addDecoration($userId, $keys, $lst) {
    $decoration = new Decoration;
    foreach (Constants::REQURED_DATA_FIELD_BANNERS as $key) {
      if (in_array($key, $keys) == true) {
        $banners = BannerShops::createBanner($userId, $keys, $lst);
        $decoration->id_banner = $banners;
        break;
      }
    }
    foreach (Constants::DATA_FIELD_CATEGORY_IMAGE as $key) {
      if (in_array($key, $keys) == true) {
        $imageCategory = ImageCategoryShops::createImageCategory($userId, $keys, $lst);
        $decoration->id_image_category_shop  = $imageCategory;
        break;
      }
    }
    foreach(Constants::DATA_FIELD_DECORATION as $key) {
      if (in_array($key, $keys) == true) {
        $decoration->$key = $lst[$key];
      }
    }
    $decoration->save();
    return $decoration;
  }
}