<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Models\BankAccount;

class BankAccounts {
  public static function addCard($userId, $keys, $lst) {
    $bank = BankAccount::where("user_id", '=', $userId)->where('account_number', '=',$lst['account_number'])->first();
    if ($bank) {
      return false;
    }
    $bankDefault = 0;
    $default = BankAccount::where("user_id", '=', $userId)->first();
    if ($default ==  null) {
      $bankDefault = 1;
    }
    $bankAccount = new BankAccount;
    $bankAccount->user_id = $userId;
    $bankAccount->default = $bankDefault;
    foreach ($keys as $key) {
      if (in_array($key, Constants::REQUIRED_DATE_FIELD_TYPE_BANK_ACCOUNT) == true){
        $bankAccount->$key = $lst[$key];
      }
    }
    $success = $bankAccount->save();
    return $bankAccount;
  }

  public static function getAllCards($userId, $lst) {
    $bank = BankAccount::where('user_id', '=', $userId)->get();
    return $bank;
  }

  public static function getCard($userId, $id) {
    $bank = BankAccount::where('user_id', '=', $userId)->where('id', '=', $id)->get();
    return $bank;
  }

  public static function destroyCard($userId, $id) {
    $bank = BankAccount::where("user_id", '=', $userId)->where('id', '=', $id)->first();
    if ($bank->default == 1) {
      return false;
    } else {
      $bank->delete();
      return true;
    }
  }

  public static function changeDefault($userId, $id) {
    $bank = BankAccount::where("user_id", '=', $userId)->where('id', '=', $id)->first();
    if ($bank->default == 1) {
      return false;
    } else {
      $bankDefault = BankAccount::where('user_id', '=', $userId)->where('id', '<>', $id)->where('default', '=', 1)->first();
      $bankDefault->default = 0;
      $bankDefault->save();
      $bank->default = 1;
      $bank->save();
      return $bank;
    }
  }
}