<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Phone;

class Phones {
  public static function checkExists($lst) {
    $phoneExists = Phone::where('phone', '=', $lst['phone'])->first();
    if ($phoneExists) {
      return false;
    } else {
      return true;
    }
  }

  public static function register($lst, $keys, $user) {
    $phone = new Phone;
    $phone->user_id = $user->id;
    foreach ($keys as $key)
      if (in_array($key, Constants::REQUIRED_DATA_FIELD_PHONE) == true)
        $phone->$key = $lst[$key];

    $successPhone = $phone->save();
    return $phone;
  }
}