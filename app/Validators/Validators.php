<?php
namespace App\Validators;
use Constants;

class Validators
{
  public static function requiredFieldProduct ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_PRODUCT as $key)
      if (array_key_exists($key, $lst) == false)
        return false;
  }
  public static function requiredFieldPromotion ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_PROMOTION as $key)
      if (array_key_exists($key, $lst) == true) {
        foreach(Constants::REQUIRED_DATA_FIELD_PROMOTION as $key)
          if (array_key_exists($key, $lst) == false) {
            return false;
          }
      }
  }
  public static function requiredFieldShippingType ($lst) {
    foreach (Constants::REQUIRED_DATA_FIELD_TYPE_SHIPPING as $key)
      if (array_key_exists($key, $lst) == false)
          return false;
  }
}