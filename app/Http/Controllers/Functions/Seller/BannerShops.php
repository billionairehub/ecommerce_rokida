<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Models\BannerShop;
use App\Http\Controllers\Functions\Seller\ResizeImage;
use App\Models\Shop;

class BannerShops {
  public static function addBanner ($userId, $lst) {
    $shop = Shop::where('user_id', '=', $userId)->first('id');
    for ( $i = 0; $i < count($lst['name']); $i++){
      $banner = new BannerShop;
      if ($lst['type_banner'][$i] == 1) {
        //Video
        $banner->shop_id = $shop->id;
        $uri = ResizeImage::video($lst['image'][$i][0]);
        $banner->url_img = $uri;
        $banner->content = $lst['content'][$i];
        $banner->url_pro = $lst['url'][$i];
        $banner->type = (int)$lst['type_banner'][$i];
        $banner->save();
      } else if ($lst['type_banner'][$i] == 2 || $lst['type_banner'][$i] == 3) {
        //Image
        $banner->shop_id = $shop->id;
        $url = ResizeImage::resize($lst['image'][$i]);
        $banner->url_img = $url;
        $banner->content = $lst['content'][$i];
        $banner->url_pro = $lst['url'][$i];
        $banner->type = (int)$lst['type_banner'][$i];
        $banner->save();
      }
    }
    return true;
  }

  public static function createBanner ($userId, $keys, $lst) {
    $shop = Shop::where('user_id', '=', $userId)->first('id');
    $id = "";
    for ($i = 0; $i < count($lst['name_banner']); $i++) {
      $banner = new BannerShop;
      if ($lst['type_banner'][$i] == 1) {
        //Video
        $banner->shop_id = $shop->id;
        $uri = ResizeImage::video($lst['image_banner'][$i][0]);
        $banner->url_img = $uri;
        $banner->content = $lst['content_banner'][$i];
        $banner->url_pro = $lst['url_banner'][$i];
        $banner->name = $lst['name_banner'][$i];
        $banner->type = (int)$lst['type_banner'][$i];
        $banner->save();
        $id = $id . $banner->id;
        if ($i < count($lst['name_banner']) - 1) {
          $id = $id . ',';
        }
      } else if ($lst['type_banner'][$i] == 2 || $lst['type_banner'][$i] == 3) {
        //Image
        $banner->shop_id = $shop->id;
        $url = ResizeImage::resize($lst['image_banner'][$i]);
        $banner->url_img = $url;
        $banner->content = $lst['content_banner'][$i];
        $banner->url_pro = $lst['url_banner'][$i];
        $banner->name = $lst['name_banner'][$i];
        $banner->type = (int)$lst['type_banner'][$i];
        $banner->save();
        $id = $id . $banner->id;
        if ($i < count($lst['name_banner']) - 1) {
          $id = $id . ',';
        }
      }
    }
    return $id;
  }
}