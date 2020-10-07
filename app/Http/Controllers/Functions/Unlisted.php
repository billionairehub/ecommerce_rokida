<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Product;

class Unlisted {
  public static function getListAll ($userId, $lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $name = '';
    $sku = '';
    $product_code = '';
    $branch = '';
    $category = '';
    $stockMin = Constants::STOCK_MIN;
    $stockMax = Constants::STOCK_MAX;
    $soldMin = Constants::SOLD_MIN;
    $soldMax = Constants::SOLD_MAX;
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
    if (array_key_exists('stockMin', $lst) && $lst['stockMin'] !=  null) {
        $stockMin = $lst['stockMin'];
    }
    if (array_key_exists('stockMax', $lst) && $lst['stockMax'] !=  null) {
        $stockMax = $lst['stockMax'];
    }
    if (array_key_exists('soldMin', $lst) && $lst['soldMin'] !=  null) {
        $soldMin = $lst['soldMin'];
    }
    if (array_key_exists('soldMax', $lst) && $lst['soldMax'] !=  null) {
        $soldMax = $lst['soldMax'];
    }
    if (array_key_exists('category', $lst) && $lst['category'] !=  null) {
        $cate = Category::where('name', '=', $lst['category'])->first('id');
        $category = $cate->id;
    }
    $product = Product::where('author', '=', $userId)->where('hidden', '=', 1)->where('name', 'like', '%' . $name . '%')->where('infringe', '=', 0)->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('amount', '>=', $stockMin)->where('amount', '<=', $stockMax)->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
    return $product;
  }
}