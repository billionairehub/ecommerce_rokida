<?php
namespace App\Repositories\Seller;

use App\Contracts\Seller\Sale as ContractsSale;

use Constants;

use Carbon\Carbon;

use App\Models\Backend\Product;
use App\Models\Backend\Order;
use App\Models\Backend\OrderDetail;
use App\Models\Backend\User;
// Product Banded
class SaleEloquentRepository extends EloquentRepository implements ContractsSale
{

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \App\Models\Backend\Order::class;
  }

  public function getListAll($lst) {
    $userId = User::getUserId();
    if (array_key_exists('type', $lst) && $lst['type'] == Constants::UNPAID) {
      $result = SaleEloquentRepository::unpaid($userId, $lst);
    } else if (array_key_exists('type', $lst) && $lst['type'] == Constants::TOSHIP) {
      $result = SaleEloquentRepository::toship($userId, $lst);
    } else if (array_key_exists('type', $lst) && $lst['type'] == Constants::SHIPPING) {
      $result = SaleEloquentRepository::shipping($userId, $lst);
    } else if (array_key_exists('type', $lst) && $lst['type'] == Constants::COMPLETED) {
      $result = SaleEloquentRepository::completed($userId, $lst);
    } else if (array_key_exists('type', $lst) && $lst['type'] == Constants::CANCELLED) {
      $result = SaleEloquentRepository::cancelled($userId, $lst);
    } else if (array_key_exists('type', $lst) && $lst['type'] == Constants::RETURNLIST) {
      $result = SaleEloquentRepository::returnlist($userId, $lst);
    } else {
      $result = SaleEloquentRepository::saleAll($userId, $lst);
    }
    return $result;
  }

  private function unpaid ($userId, $lst) {
    $keyword = '';
    if (array_key_exists('search', $lst) && $lst['search'] != null) {
      $keyword = $lst['search'];
    }
    $orders = Order::where('user_id', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_ship', Constants::WAIT_FOR_CONFIRMATION)->get();
    for ($i = 0; $i < count($orders); $i++) {
      $orderDetail = OrderDetail::where('order_id', $orders[$i]->id)->get();
      $orders[$i]->total = count($orderDetail);
    }
    return $orders;
  }

  private function toship ($userId, $lst) {
    if (array_key_exists('source', $lst) && $lst['source'] == Constants::TO_PROCESS) {
      $result = SaleEloquentRepository::toProcess($userId, $lst);
    } else if (array_key_exists('source', $lst) && $lst['source'] == Constants::PROCESS) {
      $result = SaleEloquentRepository::process($userId, $lst);
    } else {
      $result = SaleEloquentRepository::processAll($userId, $lst);
    }
    return $result;
  }

  private function toProcess ($userId, $lst) {
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
  }

  private function process ($userId, $lst) {
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
  }

  private function processAll ($userId, $lst) {
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

  private function shipping ($userId, $lst) {
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
  }

  private function completed ($userId, $lst) {
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
  }

  private function cancelled ($userId, $lst) {
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
  }

  private function returnlist ($userId, $lst) {
    if (array_key_exists('refund_status', $lst) && $lst['refund_status'] == Constants::REFUND_UNPROCESSED) {
      $result = SaleEloquentRepository::refundUnprocessed($userId, $lst);
    } else if (array_key_exists('refund_status', $lst) && $lst['refund_status'] == Constants::REFUND_PROCESSED) {
      $result = SaleEloquentRepository::refundProcessed($userId, $lst);
    } else {
      $result = SaleEloquentRepository::refundAll($userId, $lst);
    }
    return $result;
  }

  private function refundUnprocessed ($userId, $lst) {
    $keyword = '';
    if (array_key_exists('search', $lst) && $lst['search'] != null) {
      $keyword = $lst['search'];
    }
    $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', '=', Constants::RETURNS_AND_REFUND_WITHOUT_HANDLING)->get();
    return $orders;
  }

  private function refundProcessed ($userId, $lst) {
    $keyword = '';
    if (array_key_exists('search', $lst) && $lst['search'] != null) {
      $keyword = $lst['search'];
    }
    $orders = Order::where('user_id', '=', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', '=', Constants::RETURNS_AND_REFUND_HANDLED)->get();
    return $orders;
  }

  private function refundAll ($userId, $lst) {
    $keyword = '';
    if (array_key_exists('search', $lst) && $lst['search'] != null) {
      $keyword = $lst['search'];
    }
    $orders = Order::where('user_id', $userId)->where('order_code', 'like', '%'. $keyword . '%')->where('status_order', Constants::RETURNS_AND_REFUND_WITHOUT_HANDLING)->orWhere('status_order', Constants::RETURNS_AND_REFUND_HANDLED)->get();
    return $orders;
  }

  private function saleAll ($userId, $lst) {
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
