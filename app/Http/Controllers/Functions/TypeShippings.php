<?php
namespace App\Http\Controllers\Functions;
use Constants;
use RecipeShipping;

use App\TypeShipping;

class TypeShippings {
  public static function addShippingChannels($productId, $keys, $lst) {
    $shippingChannels = str_replace(' ', '', $lst['shipping_channels']);
    $lstShippingChannels = explode(',', $shippingChannels);
    for ($i = 0; $i < count($lstShippingChannels); $i++) {
      $typeShipping = new TypeShipping;
      $typeShipping->product_id = $productId;
      foreach ($keys as $key) {
        if (in_array($key, Constants::REQUIRED_DATA_FIELD_TYPE_SHIPPING) == true) {
          if ($key === 'shipping_channels')
            $typeShipping->shipping_channels = intval($lstShippingChannels[$i]);
          else 
            $typeShipping->$key = $lst[$key];
        }
      }
      $typeShipping->fees = RecipeShipping::giaoHangNhanh($lst['weight'], $lst['length'], $lst['width'], $lst['height']);
      $typeShipping->save();
    }
  }

  public static function deleteShippingChannel($id) {
    $typeShippings = TypeShipping::where('product_id', '=', $id)->get();
    if (!$typeShippings) {
      return false;
    }
    foreach ($typeShippings as $typeShipping) {
      $typeShipping->delete();
    }
    return true;
  }

  public static function deleteShipping ($lst) {
    $shipping = TypeShipping::where('product_id', '=', $lst['product'])->get();
    if (count($shipping) == 1)
      return 0;
    else {
      $delShipping = TypeShipping::where('product_id', '=', $lst['product'])->where('id', '=', $lst['shipping'])->first();
      $delShipping->delete();
      return 1;
    }
  }
}