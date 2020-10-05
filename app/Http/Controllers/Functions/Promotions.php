<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Promotion;

class Promotions {
  public static function addPromotion($productId, $keys, $lst) {
    $promotion = new Promotion;
    $promotion->product_id = $productId;
    foreach ($keys as $key) {
      if (in_array($key, Constants::REQUIRED_DATA_FIELD_PROMOTION) == true)
        $promotion->$key = $lst[$key];
    }
    $successPromotion = $promotion->save();
    return $successPromotion;
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
}