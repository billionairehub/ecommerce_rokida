<?php
namespace App\Http\Controllers\Functions\Seller;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Constants;

use App\Http\Controllers\Functions\Seller\ResizeImage;

use App\Models\Shop;
use App\Models\User;

class ProfileShop extends ServiceProvider{
  public static function profileShop ($userId) {
    $shop = Shop::where('user_id', '=', $userId)->first();
    $user = User::where('id', '=', $shop->user_id)->first();
    $shop->user_id = $user;
    return $shop;
  }

  public static function updateShop ($userId, $keys, $input) {
    $shop = Shop::where('user_id', '=', $userId)->first();
    foreach ($keys as $key) {
      if ($key == 'des_image_video') {
        $uri = "";
        for ($i = 0; $i < count($input['des_image_video']); $i++) {
          $type = $input['des_image_video'][$i]->getClientOriginalExtension();
          if ($type == 'mp4') {
            $size = $input['des_image_video'][$i]->getSize() / 1024 / 1024;
            if ($size > 5) {
              return false;
            } else {
              $url = ResizeImage::video($input['des_image_video'][$i]);
              $uri = $uri . $url;
              if ($i < count($input['des_image_video']) - 1) {
                $uri = $uri . ',';
              }
            }
          } else if ($type == 'png' || $type == 'jpg' || $type == 'jpeg') {
            $arr = [];
            array_push($arr, $input['des_image_video'][$i]);
            $url = ResizeImage::resize($arr);
            $uri = $uri . $url;
            if ($i < count($input['des_image_video']) - 1) {
              $uri = $uri . ',';
            }
          }
        }
        $shop->$key = $uri;
      } else if ($key == 'avatar_shop' || $key == 'cover_avatar') {
          $uri = ResizeImage::resize($input[$key]);
          $shop->$key = $uri;
      } else $shop->$key = $input[$key];
    }
    $shop->save();
    return $shop;
  }
}