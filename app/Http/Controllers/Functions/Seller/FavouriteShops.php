<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\RateReviewShop;

class FavouriteShops {
  public static function dashboard($userId, $lst) {
    // Number of Buyers
    $shop = Shop::where('user_id', '=', $userId)->first();
    $orderDetail = OrderDetail::where('shop_id', '=', $shop->id)->get('order_id');
    $allOrder = Order::whereIn('id', $orderDetail)->where('status_ship', '=', Constants::CANCELED)->orWhere('status_ship', '=', Constants::DELIVERED)->get();
    $order = Order::whereIn('id', $orderDetail)->get();
    $buyer = 0;
    for ($i = 0; $i < count($order); $i++) {
      $count = 0;
      for ($j = $i + 1; $j < count($order); $j++) {
        if ($order[$i]->user_id == $order[$j]->user_id) {
          $count = 1;
        }
      }
      if ($count == 0) {
        $buyer = $buyer + 1;
      }
    }
    // Successful orders
    $successfulOrders = Order::whereIn('id', $orderDetail)->where('status_ship', '=', Constants::DELIVERED)->get();
    // Shop Reviews
    $shopRate = RateReviewShop::where('shop_id', $shop->id)->where('vote', '<>', NULL)->get('vote');
    $shopReviews = 0;
    foreach ($shopRate as $vote) {
      $shopReviews = $shopReviews + $vote->vote;
    }
    $shopReviews = floor(($shopReviews / count($shopRate)) * 10) / 10;
    // Unsuccessful Application Rate
    $percent = 100 / count($allOrder);
    $unsuccessfulOrders = Order::whereIn('id', $orderDetail)->where('status_ship', '=', Constants::CANCELED)->get();

    $obj = (object)[];
    $obj->buyer = $buyer;
    $obj->successful_orders = count($successfulOrders);
    $obj->shop_reviews = $shopReviews;
    $obj->unsuccessful_orders = floor((count($unsuccessfulOrders) * $percent) * 10) / 10;
    $obj = json_encode($obj, true);
    return $obj;
  }
}