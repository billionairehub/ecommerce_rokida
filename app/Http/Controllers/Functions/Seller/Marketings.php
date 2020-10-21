<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Marketing;
use App\Models\Shop;
use App\Models\Order;

class Marketings {
  public static function addVoucher($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldVoucher($lst, $keys);
    if ($isValid == false) {
      return false;
    }
    $marketing = new Marketing;
    $marketing->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_VOUCHER as $key) {
      if ($key == 'code') {
        $shop = Shop::where('user_id', '=', $userId)->first();
        $marketing->code = strtoupper(substr($shop->shop_name, 0, 4) . $lst['code']);
      } else {
        $marketing->$key = $lst[$key];
      }
    }
    $marketing->save();
    return $marketing;
  }
  public static function listVoucher($userId, $lst) {
      $now = Carbon::now();
      $now->setTimezone(7);
    if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_HAPPENNING) {
      $marketing = Marketing::where('user_id', '=', $userId)->where('time_start', '<=', $now)->where('time_end', '>=', $now)->get();
      return $marketing;
    } else if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_UPCOMING) {
      $marketing = Marketing::where('user_id', '=', $userId)->where('time_start', '>', $now)->get();
      return $marketing;
    } else if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_FINISHED) {
      $marketing = Marketing::where('user_id', '=', $userId)->where('time_end', '<', $now)->get();
      return $marketing;
    } else {
      $marketing = Marketing::where('user_id', '=', $userId)->get();
      return $marketing;
    }
  }
  public static function dashboard($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    $marketing = Marketing::where('user_id', '=', $userId)->where('time_start', '<', $now)->get();
    $obj = (object)[];
    // 
    $totalUsed = 0;
    for ($i = 0; $i < count($marketing); $i++) {
      $totalUsed = $totalUsed + $marketing[$i]->used;
    }
    $obj->used = $totalUsed;
    // 
    $shop = Shop::where('user_id', '=', $userId)->first();
    $sold = Order::where('shop_id', '=', $shop->id)->where('status_ship', '=', Constants::DELIVERED)->where('voucher', '<>', NULL)->get();
    $totalSold = $totalRevenue = 0;
    for ($i = 0; $i < count($sold); $i++) {
      $totalSold = $totalSold + $sold[$i]->amount;
      $totalRevenue = $totalRevenue + $sold[$i]->total_bill;
    }
    // Buyer
    $totalBuyer = Order::where('shop_id', '=', $shop->id)->where('status_ship', '=', Constants::DELIVERED)->where('voucher', '<>', NULL)->get();
    $buyer = 0;
    for ($i = 0; $i < count($totalBuyer); $i++) {
      $count = 0;
      for ($j = $i + 1; $j < count($totalBuyer); $j++) {
        if ($totalBuyer[$i]->user_id == $totalBuyer[$j]->user_id) {
          $count = 1;
        }
      }
      if ($count == 0) {
        $buyer = $buyer + 1;
      }
    }
    
    $obj->sold = $totalSold;
    $obj->revenue = $totalRevenue;
    $obj->average = $totalRevenue / count($sold);
    $obj->buyer = $buyer;

    $obj = '{"sold":' . $totalSold . ', "revenue":' . $totalRevenue . ', "average":' . $totalRevenue / count($sold) . ', "buyer":' . $buyer . '}';
    $result = json_decode($obj, true);
    return $result;
  }
}