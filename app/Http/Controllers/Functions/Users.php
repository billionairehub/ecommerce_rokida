<?php
namespace App\Http\Controllers\Functions;
use Illuminate\Support\Facades\Auth;
use Constants;

use App\User;

class Users {
  public static function checkExists($lst) {
    $phoneExists = User::where('phone', '=', $lst['phone'])->first();
    if ($phoneExists) {
      return false;
    } else {
      return true;
    }
  }

  public static function register($lst, $keys) {
    $user = new User;
    foreach ($keys as $key)
      if (in_array($key, Constants::REQUIRED_DATA_FIELD_USER) == true)
        $user->$key = $lst[$key];
    foreach ($keys as $key)
      if (in_array($key, Constants::DATA_FIELD_USER) == true){
        if ($key == 'password') {
          //
        } else {
          $user->$key = $lst[$key];
        }
      }

    foreach ($keys as $key)
    if (in_array($key, Constants::DATA_FIELD_USER) == true){
      if ($key == 'password') {
        $user->$key = $lst[$key];
      } else {
        $user->$key = $lst[$key];
      }
    }
    
    $successUser = $user->save();
    return $user;
  }

  public static function login($lst, $keys) {
    // foreach ($keys as $key) {
    //   if ($key != 'password') {
    //     $username = $key;
    //   }
    // }
    // $credentials = [
    //   $username => $lst[$username],
    //   'password' => $lst['password']
    // ];
    // if (!$token = auth('api')->attempt($credentials)) {
    //   //
    // }
    // dd($token);
  }
}