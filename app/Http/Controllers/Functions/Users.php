<?php
namespace App\Http\Controllers\Functions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Constants;

use App\Custommer;

class Users {
  public static function checkExists($lst) {
    $phoneExists = Custommer::where('phone', '=', $lst['phone'])->first();
    if ($phoneExists) {
      return false;
    } else {
      return true;
    }
  }

  public static function register($lst, $keys) {
    $user = new Custommer;
    foreach ($keys as $key)
      if (in_array($key, Constants::REQUIRED_DATA_FIELD_USER) == true)
        $user->$key = $lst[$key];
      foreach ($keys as $key)
      if (in_array($key, Constants::DATA_FIELD_USER) == true){
        if ($key == 'passwords') {
          $user->passwords = Hash::make($lst['passwords']);
        } else {
          $user->$key = $lst[$key];
        }
      }
    $successUser = $user->save();
    return $user;
  }
}