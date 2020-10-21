<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use RecipeShipping;

use App\Models\TypeShipping;

class TypeShippings {
  public static function addShippingChannels($productId, $keys, $lst) {
    for ($i = 0; $i < count($lst['shipping_channels']); $i++) {
      $typeShipping = new TypeShipping;
      $typeShipping->product_id = $productId;
      foreach ($keys as $key) {
        if (in_array($key, Constants::REQUIRED_DATA_FIELD_TYPE_SHIPPING) == true) {
          if ($key === 'shipping_channels')
            $typeShipping->shipping_channels = intval($lst['shipping_channels'][$i]);
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

  public static function addShipping ($lst, $input) {

    $shippingExists = TypeShipping::where('product_id', '=', $lst['product'])->get('shipping_channels');
    $arrayShippingExists = [];
    foreach ($shippingExists as $shiping) {
      array_push($arrayShippingExists, $shiping->shipping_channels);
    }

    $parameterShipping = TypeShipping::where('product_id', '=', $lst['product'])->first();
    foreach ($input['shipping_channels'] as $key) {
      if (in_array($key, $arrayShippingExists) == false) {
        $typeShipping = new TypeShipping;
        $typeShipping->product_id =  $lst['product'];
        $typeShipping->shipping_channels = intval($key);
        $typeShipping->weight = intval($parameterShipping->weight);
        $typeShipping->length = intval($parameterShipping->length);
        $typeShipping->width = intval($parameterShipping->width);
        $typeShipping->height = intval($parameterShipping->height);
        $typeShipping->fees = intval(RecipeShipping::giaoHangNhanh($parameterShipping->weight, $parameterShipping->length, $parameterShipping->width, $parameterShipping->height));
        $typeShipping->save();
      }
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

  public static function showAll ($id) {
    $shipping = TypeShipping::where('product_id', '=', $id)->get();
    if (count($shipping) == 0) {
      return false;
    } else {
      return $shipping;
    }
  }
}