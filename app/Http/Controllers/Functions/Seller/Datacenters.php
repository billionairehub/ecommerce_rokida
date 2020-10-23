<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Shop;
use App\Models\VisitView;
use App\Models\Product;
use App\Models\ProductView;

class Datacenters {
  public static function dashboard($userId, $lst) {
    $shop = Shop::where('user_id', $userId)->first();
    $orderDetail = OrderDetail::where('shop_id', $shop->id)->get('order_id');
    // Doanh thu
    $datacenterRevenue = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->sum('total_bill');
    // Đơn hàng
    $datacenterOrder = Order::whereIn('id', $orderDetail)->get()->count();
    // Doanh thu / đơn hàng
    $countDatacenterRevenue = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->count();
    $turnoverOfOrder = (int)$datacenterRevenue / (int)$countDatacenterRevenue;
    // Lượt truy cập
    $visits = VisitView::where('shop_id', $shop->id)->sum('visits');
    // Lượt xem
    $views = VisitView::where('shop_id', $shop->id)->sum('views');
    // Tỉ lệ chuyển đổi khách đặt hàng trên lượt truy cập
    $guestOrder = Order::whereIn('id', $orderDetail)->count();
    $personVisit = 100 / (int)$visits;
    $conversionRate = (floor( (int)$guestOrder * $personVisit) * 10) / 10;
    // Thứ hạng sản phẩm theo doanh thu
    // + Theo doanh thu
    $revenue = OrderDetail::where('shop_id', $shop->id)->get();
    $arrRevenue = [];
    for ($i  = 0; $i < count($revenue); $i++) {
      $quantity = $revenue[$i]->quantity;
      for ($j = $i + 1; $j < count($revenue); $j++) {
        if ($revenue[$i]->product_id == $revenue[$j]->product_id) {
          $quantity = $quantity + $revenue[$j]->quantity;
        }
      }
      if (array_key_exists($revenue[$i]->product_id, $arrRevenue) == false) {
        $product = Product::where('id', $revenue[$i]->product_id)->first('price');
        $totalMoney = (int)$product->price * $quantity;
        $obj = $totalMoney;
        //$obj = json_decode($obj, true);
        $arrRevenue[$revenue[$i]->product_id] = $obj;
      }
    }
    arsort($arrRevenue);
    $keys = array_keys($arrRevenue);
    $arrayProductRevenue = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->total_revenue = $arrRevenue[$key];
      array_push($arrayProductRevenue, $parseProduct);
      $i++;
    }
    // + Theo số sản phẩm đã bán
    $orderOtherCancel = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->where('status_ship', '<>', Constants::WAIT_FOR_CONFIRMATION)->get('id');
    $productsSold = OrderDetail::whereIn('order_id', $orderOtherCancel)->get();
    $arrProductsSold = [];
    for ($i  = 0; $i < count($productsSold); $i++) {
      $quantity = $productsSold[$i]->quantity;
      for ($j = $i + 1; $j < count($productsSold); $j++) {
        if ($productsSold[$i]->product_id == $productsSold[$j]->product_id) {
          $quantity = $quantity + $productsSold[$j]->quantity;
        }
      }
      if (array_key_exists($productsSold[$i]->product_id, $arrProductsSold) == false) {
        $product = Product::where('id', $productsSold[$i]->product_id)->first('price');
        $totalMoney = (int)$product->price * $quantity;
        $obj = $totalMoney;
        //$obj = json_decode($obj, true);
        $arrProductsSold[$productsSold[$i]->product_id] = $obj;
      }
    }
    arsort($arrProductsSold);
    $keys = array_keys($arrProductsSold);
    $arrayProductsSold = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->total_revenue = $arrProductsSold[$key];
      array_push($arrayProductsSold, $parseProduct);
      $i++;
    }
    // + Theo lượt xem
    $product = Product::where('author', $userId)->get('id');
    $productView = ProductView::whereIn('product_id', $product)->orderByDesc('views')->take(Constants::TOP_PRODUCT)->get();
    //$keys = array_keys($productView);
    if (count($productView) < Constants::TOP_PRODUCT) {
      $count = count($productView);
    } else {
      $count = Constants::TOP_PRODUCT;
    }
    $arrayViews = [];
    for ($i = 0; $i < $count; $i++) {
      $parseProduct = Product::where('id', $productView[$i]->product_id)->first();
      array_push($arrayViews, $parseProduct);
    }
    // + Theo tỷ lệ chuyển đổi
    $orderOtherCancel = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->where('status_ship', '<>', Constants::WAIT_FOR_CONFIRMATION)->get('id');
    $orderDetail = OrderDetail::whereIn('order_id', $orderOtherCancel)->get();
    $arrProductsRatio = [];
    for ($i  = 0; $i < count($orderDetail); $i++) {
      $quantity = 1;
      for ($j = $i + 1; $j < count($orderDetail); $j++) {
        if ($orderDetail[$i]->product_id == $orderDetail[$j]->product_id) {
          $quantity = $quantity + 1;
        }
      }
      if (array_key_exists($orderDetail[$i]->product_id, $arrProductsRatio) == false) {
        $arrProductsRatio[$orderDetail[$i]->product_id] = $quantity;
      }
    }
    arsort($arrProductsRatio);
    $keys = array_keys($arrProductsRatio);
    $arrayProductRatio = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      array_push($arrayProductRatio, $parseProduct);
      $i++;
    }
    // Thứ hạng ngành hàng
    // + Theo doanh thu
    $object = (object)[];
    $object->datacenter_revenue = $datacenterRevenue;
    $object->datacenter_order = $datacenterOrder;
    $object->turnover_order = $turnoverOfOrder;
    $object->visits = $visits;
    $object->views = $views;
    $object->conversion_rate = $conversionRate;
    $object->revenue_follow_product = $arrayProductRevenue;
    $object->products_sold = $arrayProductsSold;
    $object->products_view = $arrayViews;
    $object->products_ratio = $arrayProductRatio;
    $object = json_encode($object, true);
    return $object;
  }
}