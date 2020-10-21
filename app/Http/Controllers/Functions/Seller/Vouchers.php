<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Voucher;
use App\Models\Shop;
use App\Models\Order;

class Vouchers {
  public static function addVoucher($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldVoucher($lst, $keys);
    if ($isValid == false) {
      return 'error.please_fill_out_the_form';
    }
    $voucher = new Voucher;
    $voucher->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_VOUCHER as $key) {
      if ($key == 'code') {
        $shop = Shop::where('user_id', '=', $userId)->first();
        $voucher->code = strtoupper(substr($shop->shop_name, 0, 4) . $lst['code']);
        $existsVoucher = Voucher::where('code', '=', $voucher->code)->first();
        if ($existsVoucher) {
          return 'error.voucher_exists';
        }
      } else {
        $voucher->$key = $lst[$key];
      }
    }
    $voucher->type = Constants::VOUCHER;
    $voucher->save();
    return $voucher;
  }
  public static function listVoucher($userId, $lst) {
      $now = Carbon::now();
      $now->setTimezone(7);
    if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_HAPPENNING) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constant::VOUCHER)->where('time_start', '<=', $now)->where('time_end', '>=', $now)->get();
      return $voucher;
    } else if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_UPCOMING) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constant::VOUCHER)->where('time_start', '>', $now)->get();
      return $voucher;
    } else if (array_key_exists('promotion_type', $lst) == true && $lst['promotion_type'] == Constants::PROMOTION_STATUS_FINISHED) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constant::VOUCHER)->where('time_end', '<', $now)->get();
      return $voucher;
    } else {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constant::VOUCHER)->get();
      return $voucher;
    }
  }
  public static function dashboard($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constant::VOUCHER)->where('time_start', '<', $now)->get();
    $obj = (object)[];
    // 
    $totalUsed = 0;
    for ($i = 0; $i < count($voucher); $i++) {
      $totalUsed = $totalUsed + $voucher[$i]->used;
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