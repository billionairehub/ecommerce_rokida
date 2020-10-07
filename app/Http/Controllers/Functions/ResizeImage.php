<?php
namespace App\Http\Controllers\Functions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;

class ResizeImage {

  public static function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public static function resize($file) {
    $now = Carbon::now();
    $uri = '';
    $countImg = count($file);
    for ($i = 0 ; $i < $countImg ; $i++ ) {
      $generateName = ResizeImage::generateRandomString(10);
      $now = Carbon::now();
      $photoName = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';
      $imageOriginal = Image::make($file[$i]->getRealPath())->filesize();
      if($imageOriginal > 2000000 )
      {
        $pathResize = ($file[$i])->storeAs('./imageProductResize/',$photoName);
        $size = Image::make(Storage::get($pathResize))->resize(2000,2000)->encode();;
        Storage::put($pathResize, $size);
        $imgUrlResize = asset('/storage/imageProductResize/'.$photoName);
        $uri = $uri.$imgUrlResize;
      }
      else
      {
        $path = $file[$i]->storeAs('./imageProductOriginal/',$photoName);
        $pathResize = ($file[$i])->storeAs('./imageProductOriginal/',$photoName);
        $imgUrl = asset('/storage/imageProductOriginal/'.$photoName);
        $uri = $uri.$imgUrl;
      }
      if ($i < ($countImg - 1)) {
        $uri = $uri . ',';
      }
    }
    return $uri;
  }
}