<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;
use Crypt;

use App\Setting;

class Settings {
  public static function enablePhoneCall($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_phone_call')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableVacationMode($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_vacation_mode')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function transifyLang($userId, $lst) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'show_language')->first();
    if (array_key_exists('lang', $lst) && $lst['lang'] != null) {
      if (in_array($lst['lang'], Constants::LANGUAGE) == true) {
        if ($setting->value == $lst['lang']) {
          return $setting;
        } else {
          $setting->value = $lst['lang'];
          $setting->save();
          return $setting;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public static function creditcardPaymentEnabled($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'creditcard_payment_enabled')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function changePaymentPassword($userId, $lst) {
    if (array_key_exists('password', $lst) == false || array_key_exists('re-password', $lst) == false) {
      return "error.not_fill_the_key";
    }
    if (is_numeric($lst['password']) == false || is_numeric($lst['re-password']) == false) {
      return "error.password_is_number";
    }
    if (strlen($lst['password']) != 6 || strlen($lst['re-password']) != 6) {
      return "error.password_length_is_6";
    }
    if ($lst['password'] != $lst['re-password']) {
      return "error.password_and_repassword_not_same";
    }
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'change-payment-password')->first();
    if ($setting) {
      $setting->value = $lst['password'];
      $setting->save();
      return $setting;
    } else {
      $setting = new Setting;
      $setting->user_id = $userId;
      $setting->key = 'change-payment-password';
      $setting->value = $lst['password'];
      $setting->save();
      return $setting;
    }
  }

  public static function feedPrivate($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'feed_private')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function hideLike($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'hide_likes')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function makeOfferStatus($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'make_offer_status')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function chatStatus($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'chat_status')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableEmailNotifications($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_email_notifications')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableOrderUpdatesEmail($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_order_updates_email')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableNewsletter($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_newsletter')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableListingUpdates($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_listing_updates')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enablePersonalisedContent($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_personalised_content')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enablePushNotifications($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_push_notifications')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableNotificationsByBatch($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_notifications_by_batch')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableOrderUpdatesPush($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_order_updates_push')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableChats($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_chats')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableShopeePromotions($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_shopee_promotions')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableFollowsAndComments($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_follows_and_comments')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableProductsSoldOut($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_products_sold_out')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function enableWalletUpdates($userId) {
    $setting = Setting::where('user_id', '=', $userId)->where('key', '=', 'enable_wallet_updates')->first();
    $setting->value = !$setting->value;
    $setting->save();
    return $setting;
  }

  public static function getSetting($userId) {
    $settings = Setting::where('user_id', '=', $userId)->get();
    return $settings;
  }
}