<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Models\ImageCategoryShop;
use App\Http\Controllers\Functions\Seller\ResizeImage;
use App\Models\Shop;

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

  public static function createImageCategory ($userId, $keys, $lst) {
    $shop = Shop::where('user_id', '=', $userId)->first('id');
    $id = "";
    for ( $i = 0; $i < count($lst['name_category']); $i++){
      $imageCategory = new ImageCategoryShop;
      $imageCategory->shop_id = $shop->id;
      $url = ResizeImage::resize($lst['image_category'][$i]);
      $imageCategory->image = $url;
      $imageCategory->name = $lst['name_category'][$i];
      $imageCategory->url = $lst['url_category'][$i];
      $imageCategory->save();
      $id = $id . $imageCategory->id;
      if ($i < count($lst['name_category']) - 1) {
        $id = $id . ',';
      }
    }
    return $id;
  }
}