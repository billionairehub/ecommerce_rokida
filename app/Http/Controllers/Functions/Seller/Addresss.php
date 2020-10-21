<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use App\Models\Address;
use App\Models\User;

class Addresss {
  public static function addAddress ($userId, $keys, $lst) {
    $address = new Address;
    $address->user_id = $userId;
    foreach ($keys as $key) {
      if (in_array($key, Constants::DATA_FIELD_ADDRESS) == true && $lst[$key] != null) {
        if ($key == 'default' && $lst['default'] == 1) {
          if ($key == 'default' && $lst['default'] == 1) {
            $default = Address::where('user_id', '=', $userId)->where('default', '=', 1)->first();
            if ($default) {
              $default->default = 0;
              $default->save();
              $address->default = 1;
            } else {
              $address->default = 1;
            }
          } else {
            $default = Address::where('user_id', '=', $userId)->where('default', '=', 1)->first();
            if ($default) {
              $address->default = 0;
            } else {
              $address->default = 1;
            }
          }
        }
        else if ($key == 'pickup' && $lst['pickup'] == 1) {
          $pickup = Address::where('user_id', '=', $userId)->where('pickup', '=', 1)->first();
          if ($pickup) {
            $pickup->pickup = 0;
            $pickup->save();
            $address->pickup = 1;
          }
        }
        else if ($key == 'return' && $lst['return'] == 1) {
          $return = Address::where('user_id', '=', $userId)->where('return', '=', 1)->first();
          if ($return) {
            $return->return = 0;
            $return->save();
            $address->return = 1;
          }
        }
        else { 
          $address->$key = $lst[$key];
        }
      }
    }
    $successProduct = $address->save();
    return $address;
  }

  public static function getAllAddress ($userId) {
    $address = Address::where('user_id', '=', $userId)->orderBy('default', 'desc')->get();
    return $address;
  }

  public static function updateAddress ($userId, $keys, $lst, $id) {
    $address = Address::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$address) {
      return false;
    } else {
      foreach ($keys as $key) {
        if (in_array($key, Constants::DATA_FIELD_ADDRESS) == true && $lst[$key] != null) {
          if ($key == 'default' && $lst['default'] == 1) {
            if ($address->default == 1) {
              return false;
            }
            $default = Address::where('user_id', '=', $userId)->where('default', '=', 1)->first();
            if ($default) {
              $default->default = 0;
              $default->save();
              $address->default = 1;
            }
          }
          else if ($key == 'pickup' && $lst['pickup'] == 1) {
            if ($address->pickup == 1) {
              return false;
            }
            $pickup = Address::where('user_id', '=', $userId)->where('pickup', '=', 1)->first();
            if ($pickup) {
              $pickup->pickup = 0;
              $pickup->save();
              $address->pickup = 1;
            } else {
              $address->$key = $lst[$key];
            }
          }
          else if ($key == 'return' && $lst['return'] == 1) {
            if ($address->return == 1) {
              return false;
            }
            $return = Address::where('user_id', '=', $userId)->where('return', '=', 1)->first();
            if ($return) {
              $return->return = 0;
              $return->save();
              $address->return = 1;
            } else {
              $address->$key = $lst[$key];
            }
          }
          else {
            $address->$key = $lst[$key];
          }
        }
      }
      $successProduct = $address->save();
      return $address;
    }
  }

  public static function setDefault ($userId, $id) {
    $address = Address::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$address) {
      return false;
    }
    $default = Address::where('user_id', '=', $userId)->where('default', '=', 1)->first();
    $address->default = 1;
    $default->default = 0;
    $address->save();
    $default->save();
    return $address;
  }

  public static function pickup ($userId, $id) {
    $address = Address::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$address) {
      return false;
    }
    $pickup = Address::where('user_id', '=', $userId)->where('pickup', '=', 1)->first();
    if ($pickup) {
      $pickup->pickup = 0;
      $pickup->save();
    }
    $address->pickup = 1;
    $address->save();
    return $address;
  }

  public static function return ($userId, $id) {
    $address = Address::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if (!$address) {
      return false;
    }
    $return = Address::where('user_id', '=', $userId)->where('return', '=', 1)->first();
    if ($return) {
      $return->return = 0;
      $return->save();
    }
    $address->return = 1;
    $address->save();
    return $address;
  }

  public static function destroy ($userId, $id) {
    $address = Address::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if ($address) {
      if ($address->default == 1) {
        return false;
      }
      $address->delete();
      return $address;
    } else {
      return false;
    }
  }
}