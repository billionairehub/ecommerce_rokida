<?php
namespace App\Repositories\Seller;

use App\Contracts\Seller\Classify as ContractsClassify;

use Constants;

use Carbon\Carbon;

use App\Models\Backend\Classify;
// Product Banded
class ClassifyEloquentRepository extends EloquentRepository implements ContractsClassify
{

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
      return \App\Models\Backend\Classify::class;
  }

  public function addClassify($productId, $keys, $lst) {
    $valid = 0;
    $classifyExists = Classify::where('product_id', '=', $productId)->get();
    if (count($classifyExists) > 0) {
      for ($i = 0; $i < count($lst['classify_key']); $i++) {
        $count = 0;
        for ($j = $i + 1; $j < count($classifyExists) - 1; $j++) {
          if ($lst['classify_key'][$i] == $classifyExists[$j]->classify_key) {
            $count++;
          }
        }
        if ($count > 0) {
          $valid++;
        }
      }
    }
    for ($i = 0; $i < count($lst['classify_key']); $i++) {
      $count = 0;
      for ($j = $i + 1; $j < count($lst['classify_key']) - 1; $j++) {
        if ($lst['classify_key'][$i] == $lst['classify_key'][$j]) {
          $count++;
        }
      }
      if ($count > 0) {
        $valid++;
      }
    }
    if ($valid == 0) {
      for ($i = 0; $i < count($lst['classify_key']); $i++) {
        $classify = new Classify;
        $classify->product_id = $productId;
        foreach ($keys as $key) {
          if (in_array($key, Constants::REQUIRED_DATA_FIELD_CLASSIFY) == true)
            $classify->$key = $lst[$key][$i];
        }
        $successClassify = $classify->save();
      }
      return $classify;
    } else {
      return trans('error.classify_same');
    }
  }

  public function getAllClassify($product) {
    $classify = Classify::where('product_id', $product)->get();
    return $classify;
  }

  public function singleDelete($id) {
    $classify = Classify::where('id', $id)->first();
    $classify->delete();
    return $classify;
  }

  public function delete($product) {
    $classifyExists = Classify::where('product_id', $product)->get();
    if (count($classifyExists) == 0) {
      return trans('error.not_found_classify');
    } else {
      foreach ($classifyExists as $classify) {
        $classify->delete();
      }
      return $classifyExists;
    }
  }

  public function update ($id, $lst) {
    $classifyExists = Classify::where('id', '=', $id)->first();
    $lstClassify = Classify::where('product_id', '=', $classifyExists->product_id)->where('id', '<>', $id)->get();
    if (!$classifyExists) {
      return trans('error.not_found_classify');
    } else {
      if(count($lstClassify) > 0) {
        for ($i = 0; $i < count($lstClassify); $i++) {
          if ($lst['classify_key'] == $lstClassify[$i]->classify_key) {
            return trans('error.update_classify_fail');
          }
        }
      }
      $classifyExists->classify_key = $lst['classify_key'];
      $classifyExists->classify_value = $lst['classify_value'];
      $classifyExists->save();
      return $classifyExists;
    }
  }
}