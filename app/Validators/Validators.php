<?php
namespace App\Validators;
use Constants;

class Validators
{
  public static function requiredFieldProduct ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_PRODUCT as $key)
      if (array_key_exists($key, $lst) == false || $lst[$key] == null)
        return false;
  }

  public static function requiredFieldPromotion ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_PROMOTION as $key) {
      if (array_key_exists($key, $lst) == true) {
        foreach(Constants::REQUIRED_DATA_FIELD_PROMOTION as $key) {
          if (array_key_exists($key, $lst) == false) {
            return 0;
          }
        }
      } else {
        $count = 1;
        foreach (Constants::REQUIRED_DATA_FIELD_PROMOTION as $key) {
          if (array_key_exists($key, $lst) == false) {
            $count++;
            if ($count == count(Constants::REQUIRED_DATA_FIELD_PROMOTION)) {
              return 2;
            }
          }
        }
      }
    }
    return 1;
  }

  public static function requiredFieldClassify ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_CLASSIFY as $key) {
      if (array_key_exists($key, $lst) == true) {
        foreach(Constants::REQUIRED_DATA_FIELD_CLASSIFY as $key) {
          if (array_key_exists($key, $lst) == false) {
            return 0;
          }
        }
      } else {
        $count = 0;
        foreach (Constants::REQUIRED_DATA_FIELD_CLASSIFY as $key) {
          if (array_key_exists($key, $lst) == false) {
            $count++;
            if ($count == count(Constants::REQUIRED_DATA_FIELD_CLASSIFY)) {
              return 2;
            }
          }
        }
      }
    }
    return 1;
  }

  public static function requiredFieldShippingType ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_TYPE_SHIPPING as $key)
      if (array_key_exists($key, $lst) == false || $lst[$key] == null)
          return false;
  }

  public static function requiredFieldUser ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_USER as $key)
      if (array_key_exists($key, $lst) == false || $lst[$key] == null)
        return false;
  }

  public static function requiredFieldPhone ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_PHONE as $key)
      if (array_key_exists($key, $lst) == false || $lst[$key] == null)
        return false;
  }

  public static function requiredFieldLogin ($lst, $keys) {
    if (array_key_exists('password', $lst) == false || $lst['password'] == null) 
      return false;
    else {
      $count = 0;
      foreach (Constants::REQUIRED_LOGIN as $key)
        if (array_key_exists($key, $lst) == false || $lst[$key] == null) {
          $count++;
        }
      if ($count == count(Constants::REQUIRED_LOGIN))
        return false;
    }
    return true;
  }
}