<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\ImageCategoryShop;
use App\Http\Controllers\Functions\Seller\ResizeImage;
use App\Shop;

class ImageCategoryShops {
  public static function addCategoryImage ($userId, $lst) {
    $shop = Shop::where('user_id', '=', $userId)->first('id');
    for ( $i = 0; $i < count($lst['name']); $i++){
      $imageCategory = new ImageCategoryShop;
      $imageCategory->shop_id = $shop->id;
      $url = ResizeImage::resize($lst['image'][$i]);
      $imageCategory->image = $url;
      $imageCategory->name = $lst['name'][$i];
      $imageCategory->url = $lst['url'][$i];
      $imageCategory->save();
    }
    return true;
  }
}