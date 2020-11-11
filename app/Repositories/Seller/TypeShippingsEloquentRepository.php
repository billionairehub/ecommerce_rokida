<?php
namespace App\Repositories\Seller;

use App\Contracts\Seller\TypeShipping as ContractsTypeShipping;

use Constants;

use Carbon\Carbon;

use RecipeShipping;

use App\Models\Backend\TypeShipping;
// Product Banded
class TypeShippingsEloquentRepository extends EloquentRepository implements ContractsTypeShipping
{
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
      return \App\Models\Backend\TypeShipping::class;
  }

  public function addShippingChannels($productId, $keys, $lst) {
    $arrayShipping = [];
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
      array_push($arrayShipping, $typeShipping);
    }
    return $arrayShipping;
  }

  public function deleteShipping ($lst) {
    $shipping = TypeShipping::where('product_id', $lst['product'])->get();
    if (count($shipping) == 1)
      return trans('error.can_not_delete_shipping');
    else {
      $delShipping = TypeShipping::where('product_id', '=', $lst['product'])->where('id', '=', $lst['shipping'])->first();
      if ($delShipping) {
        $delShipping->delete();
        return $delShipping;
      }
      return trans('error.not_found_shipping');
    }
  }

  public function showAll ($lst) {
    $shipping = TypeShipping::where('product_id', '=', $lst['product'])->get();
    if (count($shipping) == 0) {
      return trans('error.not_found_shipping');
    } else {
      return $shipping;
    }
  }
}