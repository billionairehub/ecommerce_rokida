<?php
namespace App\Repositories\Seller;

use App\Repositories\Seller\EloquentRepository;

use App\Contracts\Seller\Promotion as ContractsPromotion;

use Constants;

use Carbon\Carbon;

use App\Models\Backend\Promotion;
// Product Banded
class PromotionEloquentRepository extends EloquentRepository implements ContractsPromotion
{

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
      return \App\Models\Backend\Promotion::class;
  }

  public function addPromotion($productId, $keys, $lst) {
    for ($i = 0; $i < count($lst['pro_from']); $i++) {
      $promotion = new Promotion;
      $promotion->product_id = $productId;
      foreach ($keys as $key) {
        if (in_array($key, Constants::DATA_FIELD_PROMOTION) == true)
          $promotion->$key = $lst[$key][$i];
      }
      $successPromotion = $promotion->save();
    }
    return $promotion;
  }

  public function getAllPromotion($lst) {
    $promotionExists = Promotion::where('product_id', '=', $lst)->get();
    if (count($promotionExists) == 0) {
      return trans('error.not_found_promotion');
    } else {
      return $promotionExists;
    }
  }

  public function singleDelete($id) {
    $promotionExists = Promotion::where('id', '=', $id)->first();
    if (!$promotionExists) {
      return trans('error.not_found_promotion');
    } else {
      $promotionExists->delete();
      return $promotionExists;
    }
  }

  public function delete($id) {
    $promotionExists = Promotion::where('product_id', '=', $id)->get();
    if (count($promotionExists) == 0) {
      return trans('error.not_found_promotion');
    } else {
      foreach ($promotionExists as $promotion) {
        $promotion->delete();
      }
      return $promotionExists;
    }
  }
}