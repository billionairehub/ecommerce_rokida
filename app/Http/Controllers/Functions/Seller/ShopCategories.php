<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\ShopCategory;
use App\Shop;
use App\Product;
use App\ProductShopCategory;

class ShopCategories {
  public static function addCategory ($userId, $lst) {
    if (array_key_exists('name', $lst) && $lst['name'] != null) {
      $index = ShopCategory::where('user_id', '=', $userId)->get();
      $shopCategory = new ShopCategory;
      $shopCategory->user_id = $userId;
      $shop_id = Shop::where('user_id', '=', $userId)->first('id');
      $shopCategory->shop_id = $shop_id->id;
      $shopCategory->name = $lst['name'];
      $shopCategory->index = 1;
      $success = $shopCategory->save();
      if ($success == true) {
        $index = ShopCategory::where('user_id', '=', $userId)->where('id', '<>', $shopCategory->id)->get();
        for ($i = 0; $i < count($index); $i++) {
          $index[$i]->index = $index[$i]->index + 1;
          $index[$i]->save();
        }
      }
      return $shopCategory;
    }
    return false;
  }

  public static function editCategory ($userId, $lst, $id) {
    $shopCategory = ShopCategory::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if ($shopCategory == null) {
      return false;
    } else {
      $shopCategory->name = $lst['name'];
      $shopCategory->save();
      return $shopCategory;
    }
  }
  
  public static function deleteCategory ($userId, $id) {
    $shopCategory = ShopCategory::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$shopCategory) {
      return false;
    }
    $index = ShopCategory::where('user_id', '=', $userId)->where('index', '>', $shopCategory->index)->get();
    for ($i = 0; $i < count($index); $i++) {
      $index[$i]->index = $index[$i]->index - 1;
      $index[$i]->save();
    }
    $shopCategory->delete();
    return $shopCategory;
  }

  public static function showCategory ($userId, $id) {
    $shopCategory = ShopCategory::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$shopCategory) {
      return -1;
    }
    $productCategory = ProductShopCategory::where('shop_category_id', '=', $shopCategory->id)->get();
    if (count($productCategory) == 0) {
      return 0;
    }
    $shopCategory->show = 1;
    $shopCategory->save();
    return 1;
  }

  public static function hideCategory ($userId, $id) {
    $shopCategory = ShopCategory::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$shopCategory) {
      return false;
    }
    $shopCategory->show = 0;
    $shopCategory->save();
    return $shopCategory;
  }

  public static function getAllCategory($userId, $lst) {
    $shopCategory = ShopCategory::where('user_id', '=', $userId)->get();
    if (array_key_exists('search', $lst) && $lst['search'] != null) {
      $shopCategory = ShopCategory::where('user_id', '=', $userId)->get('id');
      $productCategory = ProductShopCategory::whereIn('shop_category_id', $shopCategory)->get('product_id');
      $product = Product::whereIn('id', $productCategory)->where('name', 'like', '%' . $lst['search'] . '%')->get('id');
      $productCategory = ProductShopCategory::whereIn('product_id', $product)->get('shop_category_id');
      $shopCategory = ShopCategory::whereIn('id', $productCategory)->get();
    }
    return $shopCategory;
  }

}