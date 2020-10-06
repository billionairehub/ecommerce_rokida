<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Classify;

class Classifies {
  public static function addClassify($productId, $keys, $lst) {
    $valid = 0;
    $classifyExists = Classify::where('product_id', '=', $productId)->get();
    if (count($classifyExists) > 0) {
      for ($i = 0; $i < count($lst['classify_key']); $i++) {
        $count = 0;
        for ($j = 0; $j < count($classifyExists); $j++) {
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
      for ($j = $i + 1; $j < count($lst['classify_key']); $j++) {
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
      return true;
    } else {
      return false;
    }
  }

  public static function deleteClassify($id) {
    $classifyExists = Classify::where('product_id', '=', $id)->get();
    if (!$classifyExists) {
      return false;
    }
    foreach ($classifyExists as $classify) {
      $classify->delete();
    }
    return true;
  }

  public static function getAll($id) {
    $classifyExists = Classify::where('product_id', '=', $id)->get();
    if (count($classifyExists) == 0) {
      return false;
    } else {
      return $classifyExists;
    }
  }

  public static function singleDelete($id) {
    $classifyExists = Classify::where('id', '=', $id)->first();
    if (!$classifyExists) {
      return false;
    } else {
      $classifyExists->delete();
      return true;
    }
  }

  public static function delete($id) {
    $classifyExists = Classify::where('product_id', '=', $id)->get();
    if (count($classifyExists) == 0) {
      return false;
    } else {
      foreach ($classifyExists as $classify) {
        $classify->delete();
      }
      return true;
    }
  }

  public static function update($id, $input) {
    $classifyExists = Classify::where('id', '=', $id)->first();
    $lstClassify = Classify::where('product_id', '=', $classifyExists->product_id)->where('id', '<>', $id)->get();
    if (!$classifyExists) {
      return false;
    } else {
      if(count($lstClassify) > 0) {
        for ($i = 0; $i < count($lstClassify); $i++) {
          if ($input['classify_key'] == $lstClassify[$i]->classify_key) {
            return false;
          }
        }
      }
      $classifyExists->classify_key = $input['classify_key'];
      $classifyExists->classify_value = $input['classify_value'];
      $classifyExists->save();
      return true;
    }
  }

}
