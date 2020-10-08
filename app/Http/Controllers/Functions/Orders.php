<?php
namespace App\Http\Controllers\Functions;
use Constants;

use Carbon\Carbon;

use App\Product;
use App\Order;
use App\OrderDetail;

class Orders {
  public static function getListAll ($userId, $lst) {
    if (array_key_exists('type', $lst) && $lst['type'] == 'unpaid') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 0)->get();
      for ($i = 0; $i < count($orders); $i++) {
        $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
        $orders[$i]->total = count($orderDetail);
      }
      return $orders;
    } else if (array_key_exists('type', $lst) && $lst['type'] == 'toship') {
      if (array_key_exists('source', $lst) && $lst['type'] == 'to_process') {
        $keyword = '';
        if (array_key_exists('search', $lst) && $lst['search'] != null) {
          $keyword = $lst['search'];
        }
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 1)->get();
        for ($i = 0; $i < count($orders); $i++) {
          $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
          $orders[$i]->total = count($orderDetail);
        }
        return $orders;
      } else if (array_key_exists('source', $lst) && $lst['type'] == 'processed') {
        $keyword = '';
        if (array_key_exists('search', $lst) && $lst['search'] != null) {
          $keyword = $lst['search'];
        }
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 2)->get();
        for ($i = 0; $i < count($orders); $i++) {
          $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
          $orders[$i]->total = count($orderDetail);
        }
        return $orders;
      } else {
        $keyword = '';
        if (array_key_exists('search', $lst) && $lst['search'] != null) {
          $keyword = $lst['search'];
        }
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 1)->orWhere('shiped', '=', 2)->get();
        for ($i = 0; $i < count($orders); $i++) {
          $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
          $orders[$i]->total = count($orderDetail);
        }
        return $orders;
      }
    } else if (array_key_exists('type', $lst) && $lst['type'] == 'shipping') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 3)->get();
      for ($i = 0; $i < count($orders); $i++) {
        $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
        $orders[$i]->total = count($orderDetail);
      }
      return $orders;
    } else if (array_key_exists('type', $lst) && $lst['type'] == 'completed') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 4)->get();
      for ($i = 0; $i < count($orders); $i++) {
        $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
        $orders[$i]->total = count($orderDetail);
      }
      return $orders;
    } else if (array_key_exists('type', $lst) && $lst['type'] == 'cancelled') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('shiped', '=', 5)->get();
      for ($i = 0; $i < count($orders); $i++) {
        $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
        $orders[$i]->total = count($orderDetail);
      }
      return $orders;
    } else {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->get();
      for ($i = 0; $i < count($orders); $i++) {
        $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
        $orders[$i]->total = count($orderDetail);
      }
      return $orders;
    }
  }

  public static function returnlist ($userId, $lst) {
    if (array_key_exists('refund_status', $lst) && $lst['refund_status'] == 'refund_unprocessed') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status', '=', 0)->get();
      return $orders;
    } else if (array_key_exists('refund_status', $lst) && $lst['refund_status'] == 'refund_processed') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status', '=', 1)->get();
      return $orders;
    } else {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status', '=', 0)->orWhere('status', '=', 1)->get();
      return $orders;
    }
  }
}