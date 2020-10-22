<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Voucher;
use App\Models\Shop;
use App\Models\Order;

class FollowPrizzes {
  public static function addFollowPrizze($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldFollowPrizze($lst, $keys);
    if ($isValid == false) {
      return 'error.please_fill_out_the_form';
    }
    $voucher = new Voucher;
    $voucher->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_FOLLOW_PRIZZE as $key) {
      $voucher->$key = $lst[$key];
    }
    $voucher->type = Constants::FOLLOW_PRIZZE;
    $voucher->save();
    return $voucher;
  }

  public static function listFollowPrizze($userId, $lst) {
      $now = Carbon::now();
      $now->setTimezone(7);
    if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_HAPPENNING) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->where('time_start', '<=', $now)->where('time_end', '>=', $now)->get();
      return $voucher;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_UPCOMING) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->where('time_start', '>', $now)->get();
      return $voucher;
    } else if (array_key_exists('type', $lst) == true && $lst['type'] == Constants::PROMOTION_STATUS_FINISHED) {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->where('time_end', '<', $now)->get();
      return $voucher;
    } else {
      $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->get();
      return $voucher;
    }
  }

  public static function dashboard($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->where('time_start', '<', $now)->get();
    $listVoucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::FOLLOW_PRIZZE)->get('id');
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