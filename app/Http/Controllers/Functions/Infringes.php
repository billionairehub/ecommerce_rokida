<?php
namespace App\Http\Controllers\Functions;
use Constants;

use Carbon\Carbon;

use App\Infringe;
use App\Product;

class Infringes {
  public static function getListAll($userId, $lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $name = '';
    $sku = '';
    $product_code = '';
    $branch = '';
    if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
      $offset = $lst['offset'];
    }
    if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
        $limit = $lst['limit'];
    }
    if (array_key_exists('name', $lst) && $lst['name'] !=  null) {
        $name = $lst['name'];
    }
    if (array_key_exists('sku', $lst) && $lst['sku'] !=  null) {
        $sku = $lst['sku'];
    }
    if (array_key_exists('product_code', $lst) && $lst['product_code'] !=  null) {
        $product_code = $lst['product_code'];
    }
    if (array_key_exists('branch', $lst) && $lst['branch'] !=  null) {
        $branch = $lst['branch'];
    }
    
    $product = Product::where('author', '=', $userId)->get(['id']);
    $arrProduct = [];
    for ($i = 0; $i < count($product); $i++) {
      array_push($arrProduct, $product[$i]->id);
    }
    $now = Carbon::now();
    $infringes = Infringe::whereIn('product_id', $arrProduct)->where('error_correction_deadline', '>', $now)->get('product_id');
    $arrInfringe = [];
    for ($i = 0; $i < count($infringes); $i++) {
      array_push($arrInfringe, $infringes[$i]->product_id);
    }
    $result = Product::whereIn('id', $arrInfringe)->where('name', 'like', '%' . $name . '%')->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->limit($limit)->offset($offset)->get();
    return $result;
  }

  public static function getListHistory($userId, $lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $startTime = '1970-10-10 10:00:00';
    $endTime = Carbon::now();
    if (array_key_exists('startTime', $lst) && $lst['startTime'] !=  null) {
      $startTime = $lst['startTime'];
    }
    if (array_key_exists('endTime', $lst) && $lst['endTime'] !=  null) {
      $endTime = $lst['endTime'];
    }
    
    $product = Product::where('author', '=', $userId)->get(['id']);
    $arrProduct = [];
    for ($i = 0; $i < count($product); $i++) {
      array_push($arrProduct, $product[$i]->id);
    }
    
    $infringes = Infringe::whereIn('product_id', $arrProduct)->where('error_correction_deadline', '>=', $startTime)->where('error_correction_deadline', '<=', $endTime)->get('product_id');
    $arrInfringe = [];
    for ($i = 0; $i < count($infringes); $i++) {
      array_push($arrInfringe, $infringes[$i]->product_id);
    }
    $result = Product::whereIn('id', $arrInfringe)->limit($limit)->offset($offset)->get();
    return $result;
  }
}