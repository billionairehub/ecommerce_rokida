<?php
namespace App\Repositories\Seller;

use App\Contracts\Seller\Infringes as ContractsInfringe;

use Constants;

use Carbon\Carbon;

use App\Models\Infringe;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Shop;
// Product Banded
class InfringesEloquentRepository extends EloquentRepository implements ContractsInfringe
{

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
      return \App\Models\Product::class;
  }
  
  public function getListAll($lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $name = '';
    $sku = '';
    $product_code = '';
    $branch = '';
    if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
      $offset = $lst['offset'];
    }
    if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
        $limit = $lst['limit'];
    }
    if (array_key_exists('name', $lst) && $lst['name'] !=  null) {
        $name = $lst['name'];
    }
    if (array_key_exists('sku', $lst) && $lst['sku'] !=  null) {
        $sku = $lst['sku'];
    }
    if (array_key_exists('product_code', $lst) && $lst['product_code'] !=  null) {
        $product_code = $lst['product_code'];
    }
    if (array_key_exists('branch', $lst) && $lst['branch'] !=  null) {
        $branch = $lst['branch'];
    }
    
    $product = Product::where('author', '=', $lst['user_id'])->where('infringe', '=', 1)->get(['id']);
    $arrProduct = [];
    for ($i = 0; $i < count($product); $i++) {
      array_push($arrProduct, $product[$i]->id);
    }
    $now = Carbon::now();
    $infringes = Infringe::whereIn('product_id', $arrProduct)->where('error_correction_deadline', '>', $now)->get('product_id');
    $arrInfringe = [];
    for ($i = 0; $i < count($infringes); $i++) {
      array_push($arrInfringe, $infringes[$i]->product_id);
    }
    $product = Product::whereIn('id', $arrInfringe)->where('name', 'like', '%' . $name . '%')->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->limit($limit)->offset($offset)->get();
    
    for ($i = 0; $i < count($product); $i++) {
      $product[$i]->thumb = str_replace(' ', '', $product[$i]->thumb);
      $product[$i]->thumb = explode(', ', $product[$i]->thumb);
      $product[$i]->image = str_replace(' ', '', $product[$i]->image);
      $product[$i]->image = explode(', ', $product[$i]->image);
      $product[$i]->img_user_manual = str_replace(' ', '', $product[$i]->img_user_manual);
      $product[$i]->img_user_manual = explode(', ', $product[$i]->img_user_manual);
      $author = User::where('id', '=', $product[$i]->author)->first();
      $product[$i]->author = $author;
      $shop = Shop::where('id', '=', $product[$i]->shop_id)->first();
      $product[$i]->shop_id = $shop;
      $categories = Category::where('id', '=', $product[$i]->categories)->first();
      $product[$i]->categories = $categories;
      $infringes = Infringe::where('product_id', '=', $product[$i]->id)->first();
      $product[$i]->time_update = $infringes->time_update;
      $product[$i]->error_correction_deadline = $infringes->error_correction_deadline;
      $product[$i]->violation_at = $infringes->created_at;
    }
    return $product;
  }

  public function getListHistory($lst) {
    $offset = Constants::OFFSET;
    $limit = Constants::LIMIT;
    $startTime = '1970-10-10 10:00:00';
    $endTime = Carbon::now();
    if (array_key_exists('startTime', $lst) && $lst['startTime'] !=  null) {
      $startTime = $lst['startTime'];
    }
    if (array_key_exists('endTime', $lst) && $lst['endTime'] !=  null) {
      $endTime = $lst['endTime'];
    }
    
    $product = Product::where('author', '=', $lst['user_id'])->get(['id']);
    $arrProduct = [];
    for ($i = 0; $i < count($product); $i++) {
      array_push($arrProduct, $product[$i]->id);
    }
    
    $infringes = Infringe::whereIn('product_id', $arrProduct)->where('error_correction_deadline', '>=', $startTime)->where('error_correction_deadline', '<=', $endTime)->get('product_id');
    $arrInfringe = [];
    for ($i = 0; $i < count($infringes); $i++) {
      array_push($arrInfringe, $infringes[$i]->product_id);
    }
    $product = Product::whereIn('id', $arrInfringe)->limit($limit)->offset($offset)->get();
    for ($i = 0; $i < count($product); $i++) {
      $product[$i]->thumb = str_replace(' ', '', $product[$i]->thumb);
      $product[$i]->thumb = explode(', ', $product[$i]->thumb);
      $product[$i]->image = str_replace(' ', '', $product[$i]->image);
      $product[$i]->image = explode(', ', $product[$i]->image);
      $product[$i]->img_user_manual = str_replace(' ', '', $product[$i]->img_user_manual);
      $product[$i]->img_user_manual = explode(', ', $product[$i]->img_user_manual);
      $author = User::where('id', '=', $product[$i]->author)->first();
      $product[$i]->author = $author;
      $shop = Shop::where('id', '=', $product[$i]->shop_id)->first();
      $product[$i]->shop_id = $shop;
      $categories = Category::where('id', '=', $product[$i]->categories)->first();
      $product[$i]->categories = $categories;
      $infringes = Infringe::where('product_id', '=', $product[$i]->id)->first();
      $product[$i]->time_update = $infringes->time_update;
      $product[$i]->error_correction_deadline = $infringes->error_correction_deadline;
      $product[$i]->violation_at = $infringes->created_at;
    }
    return $product;
  }
}