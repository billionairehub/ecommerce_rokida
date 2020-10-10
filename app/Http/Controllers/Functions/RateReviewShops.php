<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\RateReviewShop;

class RateReviewShops {
  public static function rate($userId, $lst) {
    $result = RateReviewShop::where('user_id', '=', $userId)->where('')->get();
    return $result;
  }
}