<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\Voucher;
use App\Models\Shop;
use App\Models\Order;
use App\Models\OrderDetail;

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

  public static function dashboard($userId, $lst) {
    $now = Carbon::now();
    $now->setTimezone(7);
    $voucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->where('time_start', '<', $now)->get();
    $listVoucher = Voucher::where('user_id', '=', $userId)->where('type', '=', Constants::DISCOUNT)->get('id');
    $obj = (object)[];
    // 
    $totalUsed = 0;
    for ($i = 0; $i < count($voucher); $i++) {
      $totalUsed = $totalUsed + $voucher[$i]->used;
    }
    $obj->used = $totalUsed;
    // 
    $shop = Shop::where('user_id', '=', $userId)->first();
    $orderDetail = OrderDetail::where('shop_id', '=', $shop->id)->whereIn('voucher',$listVoucher)->where('voucher', '<>', NULL)->get('order_id');
    $sold = Order::whereIn('id', $orderDetail)->where('status_ship', '=', Constants::DELIVERED)->get();
    $totalSold = $totalRevenue = 0;
    for ($i = 0; $i < count($sold); $i++) {
      $totalSold = $totalSold + $sold[$i]->amount;
      $totalRevenue = $totalRevenue + $sold[$i]->total_bill;
    }
    // Buyer
    $totalBuyer = Order::whereIn('id', $orderDetail)->where('status_ship', '=', Constants::DELIVERED)->get();
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