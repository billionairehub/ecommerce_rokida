<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Classify;

class Classifies {
  public static function addClassify($productId, $keys, $lst) {
    $classify = new Classify;
    $classify->product_id = $productId;
    foreach ($keys as $key) {
      if (in_array($key, Constants::REQUIRED_DATA_FIELD_CLASSIFY) == true)
        $classify->$key = $lst[$key];
    }
    $successClassify = $classify->save();
    return $successClassify;
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
}