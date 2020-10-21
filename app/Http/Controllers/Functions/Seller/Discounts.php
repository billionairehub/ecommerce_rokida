<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Voucher;
use App\Models\Shop;
use App\Models\Order;

class Discounts {

  public static function addDiscount($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldDiscount($lst, $keys);
    if ($isValid == false) {
      return false;
    }
    $discount = new Voucher;
    $discount->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_DISCOUNT as $key) {
      $discount->$key = $lst[$key];
    }
    $discount->type = Constants::DISCOUNT;
    $discount->save();
    return $discount;
  }

  public static function listDiscount($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_HAPPENNING) {
      $discount = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->where('time_start', '<=', $now)->where('time_end', '>=', $now)->get();
      return $discount;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_UPCOMING) {
      $discount = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->where('time_start', '>', $now)->get();
      return $discount;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_FINISHED) {
      $discount = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->where('time_end', '<', $now)->get();
      return $discount;
    } else {
      $discount = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->get();
      return $discount;
    }
  }

}