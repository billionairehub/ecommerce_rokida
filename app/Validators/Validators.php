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
    if (count($lst['pro_price']) > 1) {
      for ($i = 0; $i < count($lst['pro_price']); $i++) {
        if ($i > 0) {
          if ($lst['pro_from'][$i] <= $lst['pro_to'][$i - 1]) {
            return 2;
          }
        }
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
      }
      return 1;
    } else {
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

  public static function requiredFieldBankAccount ($lst, $keys) {
    foreach (Constants::REQUIRED_DATE_FIELD_TYPE_BANK_ACCOUNT as $key) {
      if (array_key_exists($key, $lst) == false || $lst[$key] == null) {
        return false;
      }
    }
    return true;
  }

  public static function requiredFieldVoucher ($lst, $keys) {
    foreach (Constants::REQUIRED_DATA_FIELD_VOUCHER as $key) {
      if (array_key_exists($key, $lst) == false || $lst[$key] == null) {
        return false;
      }
    }
    return true;
  }
}