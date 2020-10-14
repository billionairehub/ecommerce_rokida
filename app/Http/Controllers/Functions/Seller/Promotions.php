<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Promotion;

class Promotions {
  public static function addPromotion($productId, $keys, $lst) {
    for ($i = 0; $i < count($lst['pro_from']); $i++) {
      $promotion = new Promotion;
      $promotion->product_id = $productId;
      foreach ($keys as $key) {
        if (in_array($key, Constants::DATA_FIELD_PROMOTION) == true)
          $promotion->$key = $lst[$key][$i];
      }
      $successPromotion = $promotion->save();
    }
    return true;
  }

  public static function deletePromotion($id) {
    $promotionExists = Promotion::where('product_id', '=', $id)->get();
    if (!$promotionExists) {
      return false;
    }
    foreach ($promotionExists as $promotion) {
      $promotion->delete();
    }
    return true;
  }

  public static function getAll($id) {
    $promotionExists = Promotion::where('product_id', '=', $id)->get();
    if (count($promotionExists) == 0) {
      return false;
    } else {
      return $promotionExists;
    }
  }

  public static function singleDelete($id) {
    $promotionExists = Promotion::where('id', '=', $id)->first();
    if (!$promotionExists) {
      return false;
    } else {
      $promotionExists->delete();
      return true;
    }
  }

  public static function delete($id) {
    $promotionExists = Promotion::where('product_id', '=', $id)->get();
    if (count($promotionExists) == 0) {
      return false;
    } else {
      foreach ($promotionExists as $promotion) {
        $promotion->delete();
      }
      return true;
    }
  }
  
}