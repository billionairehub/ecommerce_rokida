<?php
namespace App\Http\Controllers\Functions;
use Constants;

use Carbon\Carbon;

use App\RateReviewShop;
use App\Product;
use App\User;
use App\Classify;
use App\Shop;
use DB;

class RateReviewShops {
  public static function rate($userId, $lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $ctime_start = '1970-01-01';
    $ctime_end = Carbon::now();
    $arrProductName = Product::where('author', '=', $userId)->get('id');
    $user = RateReviewShop::whereIn('product_id', $arrProductName)->limit($limit)->offset($offset)->get('user_id');
    $arrUsername = User::whereIn('id', $user)->get('id');
    $arrModelProduct = Product::where('author', '=', $userId)->get('id');
    if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
      $offset = $lst['offset'];
    }
    if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
      $limit = $lst['limit'];
    }
    if (array_key_exists('product_name', $lst) && $lst['product_name'] != null) {
      $arrProductName = Product::where('author', '=', $userId)->where('name', 'like', '%' . $lst['product_name'] . '%')->get('id');
    }
    if (array_key_exists('username', $lst) && $lst['username'] != null) {
      $arrUsername = User::whereIn('id', $user)->where(DB::raw("CONCAT(first_name, ' ' ,last_name)"), 'like', '%' . $lst['username'] . '%')->get('id');
    }
    if (array_key_exists('model_product', $lst) && $lst['model_product'] != null) {
      $arrModelProduct = Classify::whereIn('product_id', $arrProductName)->where('classify_key', 'like', '%' . $lst['model_product'] . '%')->get('product_id');
    }
    if (array_key_exists('ctime_start', $lst) && $lst['ctime_start'] !=  null) {
      $ctime_start = $lst['ctime_start'];
    }
    if (array_key_exists('ctime_end', $lst) && $lst['ctime_end'] !=  null) {
      $ctime_end = Carbon::parse($lst['ctime_end'])->addDays(1)->format('Y-m-d');
    }
    $result = RateReviewShop::where('comment_id', '=', NULL)->where('created_at', '>=', $ctime_start)->where('created_at', '<', $ctime_end)->whereIn('product_id', $arrProductName)->whereIn('product_id', $arrModelProduct)->whereIn('user_id', $arrUsername)->limit($limit)->offset($offset)->get();
    if ((array_key_exists('category' ,$lst) && $lst['category'] != null) && (array_key_exists('replied' ,$lst) && $lst['replied'] != null)) {
      if ($lst['category'] == 0 && $lst['replied'] == 0) {
        $result = $result;
      } else if ($lst['category'] == 0 && $lst['replied'] != 0) {
        $result = $result->where('replied', '=', $lst['replied']);
      } else if ($lst['category'] != 0 && $lst['replied'] == 0) {
        $result = $result->where('vote', '=', $lst['category']);
      } else {
        $result = $result->where('vote', '=', $lst['category'])->where('replied', '=', $lst['replied']);
      }
    }
    for ($i = 0; $i < count($result); $i++) {
      $shop = Shop::where('id', '=', $result[$i]->shop_id)->get();
      $result[$i]->shop_id = $shop;
      $user = User::where('id', '=', $result[$i]->user_id)->get();
      $result[$i]->user_id = $user;
      $product = Product::where('id', '=', $result[$i]->product_id)->get();
      $result[$i]->product_id = $product;
    }
    return $result;
  }

  public static function replyReview ($userId, $input, $id) {
    $isValid = RateReviewShop::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if ($isValid == null) {
      return false;
    } else {
      $replyReview = new RateReviewShop;
      $replyReview->shop_id = $isValid->shop_id;
      $replyReview->user_id  = $userId;
      $replyReview->product_id = $isValid->product_id;
      $replyReview->content = $input['content'];
      if (array_key_exists('content_image', $input) && $nput['content_image'] != null ) {
        $uri = ResizeImage::resize($input['content_image']);
        $replyReview->content_image = $uri;
      }
      $replyReview->comment_id = $id;
      $success = $replyReview->save();
      if ($success == true) {
        $findRateReview = RateReviewShop::where('id', '=', $id)->first();
        $findRateReview->replied = 2;
        $findRateReview->save();
        return $replyReview;
      } else return false;
    }
  }

  public static function shopRatting($userId) {
    $rate = RateReviewShop::where('user_id', '=', $userId)->where('vote', '<>', NULL)->get();
    $total = 0;
    for ($i = 0; $i < count($rate); $i++) {
      $total = $total + $rate[$i]->vote;
    }
    $total = $total / count($rate);
    $total = floor($total * 10) / 10;
    $total = '{"total":' . $total . '}';
    $result = json_decode($total, true);
    return $result;
  }
}