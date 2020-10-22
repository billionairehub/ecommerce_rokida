<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Voucher;
use App\Models\Shop;
use App\Models\Order;

class Bundles {

  public static function addBundle($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldBundle($lst, $keys);
    if ($isValid == false) {
      return false;
    }
    $bundle = new Voucher;
    $bundle->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_BUNDLE as $key) {
      $bundle->$key = $lst[$key];
    }
    $bundle->type = Constants::BUNDLE;
    $bundle->save();
    return $bundle;
  }

  public static function listBundle($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_HAPPENNING) {
      $bundle = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->where('time_start', '<=', $now)->where('time_end', '>=', $now)->get();
      return $bundle;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_UPCOMING) {
      $bundle = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->where('time_start', '>', $now)->get();
      return $bundle;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_FINISHED) {
      $bundle = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->where('time_end', '<', $now)->get();
      return $bundle;
    } else {
      $bundle = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->get();
      return $bundle;
    }
  }

  public static function dashboard($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->where('time_start', '<', $now)->get();
    $listVoucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::BUNDLE)->get('id');
    $obj = (object)[];
    // 
    $totalUsed = 0;
    for ($i = 0; $i < count($voucher); $i++) {
      $totalUsed = $totalUsed + $voucher[$i]->used;
    }
    $obj->used = $totalUsed;
    // 
    $shop = Shop::where('user_id', '=', $userId)->first();
    $sold = Order::where('shop_id', '=', $shop->id)->whereIn('voucher',$listVoucher)->where('status_ship', '=', Constants::DELIVERED)->where('voucher', '<>', NULL)->get();
    $totalSold = $totalRevenue = 0;
    for ($i = 0; $i < count($sold); $i++) {
      $totalSold = $totalSold + $sold[$i]->amount;
      $totalRevenue = $totalRevenue + $sold[$i]->total_bill;
    }
    // Buyer
    $totalBuyer = Order::where('shop_id', '=', $shop->id)->whereIn('voucher',$listVoucher)->where('status_ship', '=', Constants::DELIVERED)->where('voucher', '<>', NULL)->get();
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

    $obj = '{"used":' . $totalUsed . ', "sold":' . $totalSold . ', "revenue":' . $totalRevenue . ', "average":' . $totalRevenue / count($sold) . ', "buyer":' . $buyer . '}';
    $result = json_decode($obj, true);
    return $result;
  }

}