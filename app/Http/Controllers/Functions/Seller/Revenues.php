<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Product;
use App\Order;
use App\OrderDetail;
use App\User;
use App\Shop;

class Revenues {
  public static function willPay($userId, $lst) {
    $willPay = Order::where('user_id', '=', $userId)->where('payment_status', '=', 0)->get();
    for ($i = 0; $i < count($willPay); $i++) {
      $willPay[$i]->expected_payment_date = ($willPay[$i]->updated_at)->addDays(10)->toDateTimeString();
      $shop = Shop::where('id', '=', $willPay[$i]->shop_id)->first();
      $willPay[$i]->shop_id = $shop;
      $user_id = User::where('id', '=', $willPay[$i]->user_id)->first();
      $willPay[$i]->user_id = $user_id;
      $willPay[$i]->total = $willPay[$i]->total_bill + $willPay[$i]->fees_ship;
    }
    return $willPay;
  }

  public static function Paid($userId, $lst) {
    $Paid = Order::where('user_id', '=', $userId)->where('payment_status', '=', 1)->get();
    for ($i = 0; $i < count($Paid); $i++) {
      $Paid[$i]->expected_payment_date = ($Paid[$i]->updated_at)->addDays(10)->toDateTimeString();
      $shop = Shop::where('id', '=', $Paid[$i]->shop_id)->first();
      $Paid[$i]->shop_id = $shop;
      $user_id = User::where('id', '=', $Paid[$i]->user_id)->first();
      $Paid[$i]->user_id = $user_id;
      $Paid[$i]->total = $Paid[$i]->total_bill + $Paid[$i]->fees_ship;
    }
    return $Paid;
  }

  public static function TotalWillPay($userId, $lst) {
    $willPay = Order::where('user_id', '=', $userId)->where('payment_status', '=', 0)->get();
    $total = 0;
    for ($i = 0; $i < count($willPay); $i++) {
      $total = $total + $willPay[$i]->total_bill + $willPay[$i]->fees_ship;
    }
    $total = '{"total":' . $total . '}';
    $result = json_decode($total, true);
    return $result;
  }

  public static function TotalPaid($userId, $lst) {
    if (array_key_exists('type', $lst) && $lst['type'] == 'week') {
      $dayOfWeek = Carbon::now()->dayOfWeek;
      if ($dayOfWeek == 0) {
        $day = 6;
      } else {
        $day = $dayOfWeek - 1;
      }
      $timeIs = Carbon::now()->subDays($day);
      $Paid = Order::where('user_id', '=', $userId)->where('payment_status', '=', 1)->where('payment_on', '>=', $timeIs)->get();
    } else if (array_key_exists('type', $lst) && $lst['type'] == 'month') {
      $day = Carbon::now()->format('d');
      $day = $day - 1;
      $timeIs = Carbon::now()->subDays($day);
      $Paid = Order::where('user_id', '=', $userId)->where('payment_status', '=', 1)->where('payment_on', '>=', $timeIs)->get();
    } else {
      $Paid = Order::where('user_id', '=', $userId)->where('payment_status', '=', 1)->get();
    }
    $total = 0;
    for ($i = 0; $i < count($Paid); $i++) {
      $total = $total + $Paid[$i]->total_bill + $Paid[$i]->fees_ship;
    }
    $total = '{"total":' . $total . '}';
    $result = json_decode($total, true);
    return $result;
  }

}