<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Validators;

use Carbon\Carbon;

use App\Models\HotSale;
use App\Models\Product;

class HotSales {
  public static function getHotsale ($userId) {
    $hotsale = HotSale::where('user_id', $userId)->get();
    for ($i = 0; $i < count($hotsale); $i++) {
      $arrProduct = [];
      $hotsale[$i]->product = str_replace(' ', '', $hotsale[$i]->product);
      $hotsale[$i]->product = explode(',', $hotsale[$i]->product);
      for ($j = 0; $j < count($hotsale[$i]->product); $j++) {
        $product = Product::where('id', ($hotsale[$i]->product)[$j])->first();
        array_push($arrProduct, $product);
      }
      $hotsale[$i]->product = $arrProduct;
    }
    return $hotsale;
  }

  public static function show ($userId, $id) {
    $hotsale = HotSale::where('user_id', $userId)->where('id', $id)->first();
    $arrProduct = [];
    $hotsale->product = str_replace(' ', '', $hotsale->product);
    $hotsale->product = explode(',', $hotsale->product);
    for ($j = 0; $j < count($hotsale->product); $j++) {
      $product = Product::where('id', ($hotsale->product))->first();
      array_push($arrProduct, $product);
    }
    $hotsale->product = $arrProduct;
    return $hotsale;
  }

  public static function addHotSale ($userId, $keys, $lst) {
    $isValid = Validators::requiredFieldHotsale($lst, $keys);
    if ($isValid == false) {
      return 'error.please_fill_out_the_form';
    }
    $hotsale = new HotSale;
    $hotsale->user_id = $userId;
    foreach (Constants::REQUIRED_DATA_FIELD_HOTSALE as $key) {
      $hotsale->$key = $lst[$key];
    }
    $hotsale->save();
    return $hotsale;
  }

  public static function delete ($userId, $id) {
    $hotsale = HotSale::where('user_id', $userId)->where('id', $id)->first();
    if (!$hotsale) {
      return 'error.not_found_hot_save';
    } else {
      $hotsale->delete();
      return $hotsale;
    }
  }
}