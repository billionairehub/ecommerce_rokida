<?php
namespace App\Http\Controllers\Functions\Seller;
use Illuminate\Support\Facades\Auth;
use Constants;

use App\Models\User;

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

  public static function updateProfile ($userId, $lst, $keys) {
    try {
      $user = User::where('id', $userId)->first();
      if (array_key_exists('gender', $lst) == false || $lst['gender'] == null || array_key_exists('birthday', $lst) == false || $lst['birthday'] == null) {
        return 'error.please_fill_out_the_form';
      } else {
        $user->gender = $lst['gender'];
        $user->birthday = $lst['birthday'];
        $user->save();
        return $user;
      }
    } catch (Throwable $e) {
      return false;
    }
  }

  public static function changePhone ($userId, $lst) {
    try {
      $user = User::where('id', $userId)->first();
      if (array_key_exists('phone', $lst) == false || $lst['phone'] == null) {
        return 'error.please_fill_out_the_form';
      } else {
        $userExists = User::where('phone', $lst['phone'])->where('id', '<>', $userId)->first();
        if ($userExists) {
          return 'error.phone_is_exists';
        } else {
          $user->phone = $lst['phone'];
          $user->save();
          return $user;
        }
      }
    } catch (Throwable $e) {
      return false;
    }
  }

  public static function changeMail ($userId, $lst) {
    try {
      $user = User::where('id', $userId)->first();
      if (array_key_exists('email', $lst) == false || $lst['email'] == null) {
        return 'error.please_fill_out_the_form';
      } else {
        $userExists = User::where('email', $lst['email'])->where('id', '<>', $userId)->first();
        if ($userExists) {
          return 'error.email_is_exists';
        } else {
          $user->email = $lst['email'];
          $user->save();
          return $user;
        }
      }
    } catch (Throwable $e) {
      return false;
    }
  }

  public static function changePassword ($userId, $lst) {
    try {
      $user = User::where('id', $userId)->first();
      if (array_key_exists('passwords', $lst) == false || $lst['passwords'] == null || array_key_exists('new_passwords', $lst) == false || $lst['new_passwords'] == null || array_key_exists('renew_passwords', $lst) == false || $lst['renew_passwords'] == null) {
        return 'error.please_fill_out_the_form';
      } else {
        if ($user->passwords != $lst['passwords']) {
          return 'error.password_incorect';
        } else {
          if ($lst['renew_passwords'] != $lst['new_passwords']) {
            return 'error.newpassword_notsame';
          } else {
            $user->passwords = $lst['new_passwords'];
            $user->save();
            return $user;
          }
        }
      }
    } catch (Throwable $e) {
      return false;
    }
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