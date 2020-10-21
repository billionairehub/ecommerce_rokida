<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class Orders {
  public static function getListAll ($userId, $lst) {
    if (array_key_exists('type', $lst) && $lst['type'] == 'unpaid') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::WAIT_FOR_CONFIRMATION)->get();
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
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::WAITING_TO_GET_THE_GOODS)->get();
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
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::HAS_RECEIVED_THE_GOODS)->get();
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
        $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::WAITING_TO_GET_THE_GOODS)->orWhere('status_ship', '=', Constants::HAS_RECEIVED_THE_GOODS)->get();
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
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::DELIVERY_IS_IN_PROGRESS)->get();
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
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::DELIVERED)->get();
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
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', '=', Constants::CANCELED)->get();
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
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', '=', Constants::RETURNS_AND_REFUND_WITHOUT_HANDLING)->get();
      return $orders;
    } else if (array_key_exists('refund_status', $lst) && $lst['refund_status'] == 'refund_processed') {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', '=', Constants::RETURNS_AND_REFUND_HANDLED)->get();
      return $orders;
    } else {
      $keyword = '';
      if (array_key_exists('search', $lst) && $lst['search'] != null) {
        $keyword = $lst['search'];
      }
      $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', '=', Constants::RETURNS_AND_REFUND_WITHOUT_HANDLING)->orWhere('status', '=', Constants::RETURNS_AND_REFUND_HANDLED)->get();
      return $orders;
    }
  }
}