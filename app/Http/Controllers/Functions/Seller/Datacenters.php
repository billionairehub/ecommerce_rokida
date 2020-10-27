<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Shop;
use App\Models\VisitView;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\ProductLike;
use App\Models\Chat;

class Datacenters {
  public static function dashboard($userId, $lst) {
    $startTime = '1970-01-01 00:00:00';
    $endTime = Carbon::now();
    if (array_key_exists('start_time', $lst) && $lst['start_time'] != null) {
      $startTime = $lst['start_time'];
    }
    if (array_key_exists('end_time', $lst) && $lst['end_time'] != null) {
      $startTime = $lst['end_time'];
    }
    $shop = Shop::where('user_id', $userId)->first();
    $orderDetail = OrderDetail::where('shop_id', $shop->id)->get('order_id');
    // Doanh thu
    $datacenterRevenue = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->sum('total_bill');
    // Đơn hàng
    $datacenterOrder = Order::whereIn('id', $orderDetail)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get()->count();
    // Doanh thu / đơn hàng
    $countDatacenterRevenue = Order::whereIn('id', $orderDetail)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->where('status_ship', '<>', Constants::CANCELED)->count();
    $turnoverOfOrder = (int)$datacenterRevenue / (int)$countDatacenterRevenue;
    // Lượt truy cập
    $visits = VisitView::where('shop_id', $shop->id)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->sum('visits');
    // Lượt xem
    $views = VisitView::where('shop_id', $shop->id)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->sum('views');
    // Tỉ lệ chuyển đổi khách đặt hàng trên lượt truy cập
    $guestOrder = Order::whereIn('id', $orderDetail)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->count();
    $personVisit = 100 / (int)$visits;
    $conversionRate = (floor( (int)$guestOrder * $personVisit) * 10) / 10;
    // Thứ hạng sản phẩm theo doanh thu
    // + Theo doanh thu
    $revenue = OrderDetail::where('shop_id', $shop->id)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get();
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
    $orderOtherCancel = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->where('status_ship', '<>', Constants::WAIT_FOR_CONFIRMATION)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get('id');
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
    $product = Product::where('author', $userId)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get('id');
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
    $orderOtherCancel = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->where('status_ship', '<>', Constants::WAIT_FOR_CONFIRMATION)->get('id');
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

  public static function productStatisticsOverview ($userId, $lst) {
    $startTime = '1970-01-01 00:00:00';
    $endTime = Carbon::now();
    if (array_key_exists('start_time', $lst) && $lst['start_time'] != null) {
      $startTime = $lst['start_time'];
    }
    if (array_key_exists('end_time', $lst) && $lst['end_time'] != null) {
      $startTime = $lst['end_time'];
    }
    $shop = Shop::where("user_id", $userId)->first();
    // Tổng quan về sản phẩm
    // + Lượt truy cập
    // - Lượt xem
    $productOfShop = Product::where('author', $userId)->where('shop_id', $shop->id)->get('id');
    $view = ProductView::whereIn('product_id', $productOfShop)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get()->sum('views');
    // - Số sản phẩm được xem
    $countProduct = ProductView::whereIn('product_id', $productOfShop)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get();
    $productsViewed = 0;
    for ($i = 0; $i < count($countProduct); $i++) {
      $bool = false;
      for ($j = $i + 1; $j < count($countProduct); $j++) {
        if ($countProduct[$i]->product_id == $countProduct[$j]->product_id) {
          $bool = true;
        }
      }
      if ($bool == false) {
        $productsViewed++;
      }
    }
    // - Lượt thích
    $like = ProductLike::whereIn('product_id', $productOfShop)->get()->sum('like');
    // + thêm vào giỏ hàng
    // - Sản phẩm
    $cartProduct = Product::where('author', $userId)->get()->sum('add_to_cart');
    // - Tỉ lệ chuyển đổi (theo số lần được thêm vào giỏ hàng)
    $conversionRate = (float)number_format(($cartProduct / $view), 2, '.', '');
    // + Đơn Đã Xác Nhận
    // - Sản phẩm
    $orderDetail = OrderDetail::where('shop_id', $shop->id)->get('order_id');
    $order = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::WAIT_FOR_CONFIRMATION)->where('status_ship', '<>', Constants::CANCELED)->get();
    $orderAcepted = $order->sum('amount');
    // - Doanh thu
    $revenueOrder = $order->sum('total_bill');
    // - Tỉ lệ chuyển đổi (Lượt truy cập - Đơn đã xác nhận)
    $conversionViewOrder = (float)number_format(($order->count() / $view), 2, '.', '');
    // Top 10
    // + Lượt truy cập
    $topView = ProductView::whereIn('product_id', $productOfShop)->take(10)->get();
    $arrProductView = [];
    for ($i  = 0; $i < count($topView); $i++) {
      $view = $topView[$i]->views;
      for ($j = $i + 1; $j < count($topView); $j++) {
        if ($topView[$i]->product_id == $topView[$j]->product_id) {
          $view = $view + $topView[$j]->views;
        }
      }
      if (array_key_exists($topView[$i]->product_id, $arrProductView) == false) {
        $obj = $view;
        //$obj = json_decode($obj, true);
        $arrProductView[$topView[$i]->product_id] = $obj;
      }
    }
    arsort($arrProductView);
    $keys = array_keys($arrProductView);
    $arrayProductView = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->total_view = $arrProductView[$key];
      array_push($arrayProductView, $parseProduct);
      $i++;
    }
    // + Doanh thu (Đơn đã thanh toán)
    $orderDelivered = Order::whereIn('id', $orderDetail)->where('status_ship', Constants::DELIVERED)->get('id');
    $orderDetailDelivered = OrderDetail::whereIn('order_id', $orderDelivered)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get();
    $arrRevenue = [];
    for ($i  = 0; $i < count($orderDetailDelivered); $i++) {
      $quantity = $orderDetailDelivered[$i]->quantity;
      for ($j = $i + 1; $j < count($orderDetailDelivered); $j++) {
        if ($orderDetailDelivered[$i]->product_id == $orderDetailDelivered[$j]->product_id) {
          $quantity = $quantity + $orderDetailDelivered[$j]->quantity;
        }
      }
      if (array_key_exists($orderDetailDelivered[$i]->product_id, $arrRevenue) == false) {
        $product = Product::where('id', $orderDetailDelivered[$i]->product_id)->first('price');
        $totalMoney = (int)$product->price * $quantity;
        $obj = $totalMoney;
        //$obj = json_decode($obj, true);
        $arrRevenue[$orderDetailDelivered[$i]->product_id] = $obj;
      }
    }
    arsort($arrRevenue);
    $keys = array_keys($arrRevenue);
    $arrayProductRevenue = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT || $i == 9) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->total_revenue = $arrRevenue[$key];
      array_push($arrayProductRevenue, $parseProduct);
      $i++;
    }
    
    // + Theo số sản phẩm đã bán
    $orderSell = Order::whereIn('id', $orderDetail)->where('status_ship', '<>' , Constants::CANCELED)->get('id');
    $orderDetailSell = OrderDetail::whereIn('order_id', $orderSell)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get();
    $arrTotalSell = [];
    $arrProductView = [];
    for ($i  = 0; $i < count($orderDetailSell); $i++) {
      $quantity = $orderDetailSell[$i]->quantity;
      for ($j = $i + 1; $j < count($orderDetailSell); $j++) {
        if ($orderDetailSell[$i]->product_id == $orderDetailSell[$j]->product_id) {
          $quantity = $quantity + $orderDetailSell[$j]->quantity;
        }
      }
      if (array_key_exists($orderDetailSell[$i]->product_id, $arrTotalSell) == false) {
        $obj = $quantity;
        //$obj = json_decode($obj, true);
        $arrTotalSell[$orderDetailSell[$i]->product_id] = $obj;
      }
      if (array_key_exists($orderDetailSell[$i]->product_id, $arrProductView) == false) {
        $viewProduct = ProductView::where('product_id', $orderDetailSell[$i]->product_id)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get()->sum('views');
        $productView = (float)number_format(($quantity / $viewProduct), 2, '.', '');
        $arrProductView[$orderDetailSell[$i]->product_id] = $productView;
      }
    }
    arsort($arrTotalSell);
    $keys = array_keys($arrTotalSell);
    $arrayTotalSell = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT || $i == 9) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->total_sell = $arrTotalSell[$key];
      array_push($arrayTotalSell, $parseProduct);
      $i++;
    }
    // + Đơn hàng trên lượt truy cập
    arsort($arrProductView);
    $keys = array_keys($arrProductView);
    $arrPercentProuctInview = [];
    $i  = 0;
    foreach ($keys as $key) {
      if ($i == Constants::TOP_PRODUCT || $i == 9) {
        break;
      }
      $parseProduct = Product::where('id', $key)->first();
      $parseProduct->product_view = $arrProductView[$key];
      array_push($arrPercentProuctInview, $parseProduct);
      $i++;
    }
    // + Thêm vòa giỏ hàng nhiều nhất

    // result
    $object = (object)[];
    $object->views = $view;
    $object->products_viewed = $productsViewed;
    $object->likes = $like;
    $object->cart_product = $cartProduct;
    $object->conversion_rate = $conversionRate;
    $object->order_acepted_product = $orderAcepted;
    $object->revenue_order = $revenueOrder;
    $object->conversion_view_order = $conversionViewOrder;
    $object->product_top_view = $arrayProductView;
    $object->product_top_revenue = $arrayProductRevenue;
    $object->product_top_sell = $arrayTotalSell;
    $object->product_in_view = $arrPercentProuctInview;
    $object = json_encode($object, true);
    return $object;
  }
  
  public static function productStatisticsPerformance ($userId, $lst) {
    $keyword = '';
    if (array_key_exists('keyword', $lst) && $lst['keyword'] != null) {
      $keyword = $lst['keyword'];
    }
    $product = Product::where('author', $userId)->where('name', 'like', '%' . $keyword . '%')->get();
    for ($i = 0; $i < count($product); $i++) {
      $orderDetail = OrderDetail::where('product_id', $product[$i]->id)->get('order_id');
      $order = Order::whereIn('id', $orderDetail)->where('status_ship', '<>', Constants::CANCELED)->get('id');
      $orderDetails = OrderDetail::whereIn('order_id', $order)->get()->sum('quantity');
      $product[$i]->view = ProductView::where('product_id', $product[$i]->id)->get()->sum('views');
      $product[$i]->revenue = $orderDetails * $product[$i]->price;
    }
    return $product;
  }
  
  public static function salesOverview ($userId, $lst) {
    $product = Product::where('author', $userId)->get();
    $lstProductId = Product::where('author', $userId)->get('id');
    $orderDetail = OrderDetail::whereIn('product_id', $lstProductId)->get();
    $view = 0;
    for ($i = 0; $i < count($product); $i++) {
      $view = $view + ProductView::where('product_id', $product[$i]->id)->get()->sum('views');
    }
    $buyer = $revenue = 0;
    for ($i = 0; $i < count($product); $i++) {
      $productForTotal = Product::where('author', $userId)->where('id', $orderDetail[$i]->product_id)->first();
      $revenue = $revenue + ( $productForTotal->price * $orderDetail[$i]->quantity);
      $bool = false;
      for ($j = $i + 1; $j < count($product); $j++) {
        if ($orderDetail[$i]->product_id == $orderDetail[$j]->product_id) {
          $bool = true;
        }
      }
      if ($bool == false) {
        $buyer++;
      }
    }
    $object = (object)[];
    $object->view = $view;
    $object->buyer = $buyer;
    $object->revenue = $revenue;
    $object->revenue_in_buyer = $revenue / $buyer;
    $object = json_encode($object, true);
    return $object;
  }

  public static function chat ($userId, $lst) {
    $shop = Shop::where('user_id', $userId)->first();
    $numberChat = Chat::where('shop_id', $shop->id)->get()->count();
    $chat = Chat::where('shop_id', $shop->id)->get();
    $userChat = 0;
    for ($i = 0; $i < count($chat); $i++) {
      $isExists = false;
      for ($j = $i + 1; $j < count($chat); $j++) {
        if ($chat[$i]->user_id == $chat[$j]->user_id) {
          $isExists = true;
          break;
        }
      }
      if ($isExists == false) {
        $userChat++;
      }
    }
    $feedbackChat = $chat->where('responded', '=', 1)->count();
    $noFeedbackChat = $chat->where('responded', '=', 0)->count();
    $timeFeedbackChat = $chat->where('responded', '=', 1)->sum('response_time') / $feedbackChat;

    $object = (object)[];
    $object->number_chat = $numberChat;
    $object->user_chat = $userChat;
    $object->feedback_chat = $feedbackChat;
    $object->non_feedback_chat = $noFeedbackChat;
    $object->time_feedback_chat = $timeFeedbackChat;
    $result = json_encode($object, true);
    return $result;
  }
}