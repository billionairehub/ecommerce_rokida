<?php
namespace App\Http\Controllers\Functions\Seller;
use Constants;

use Carbon\Carbon;

use App\Models\Blocklist;
use App\Models\User;

class Blocklists {
  public static function getAllList ($userId) {
    $blocklists = Blocklist::where('user_id', '=', $userId)->get();
    for ($i = 0; $i < count($blocklists); $i++) {
      $user = User::where('id', '=', $userId)->first();
      $blockPerson = User::where('id', '=', $blocklists[$i]->blocked_person)->first();
      $blocklists[$i]->user_id = $user;
      $blocklists[$i]->blocked_person = $blockPerson;
    }
    return $blocklists;
  }
  
  public static function delete ($userId, $id) {
    $blocklist = Blocklist::where('user_id', '=', $userId)->where('id', '=', $id)->first();
    if ($blocklist) {
      $blocklist->delete();
      $user = User::where('id', '=', $userId)->first();
      $blockPerson = User::where('id', '=', $blocklist->blocked_person)->first();
      $blocklist->user_id = $user;
      $blocklist->blocked_person = $blockPerson;
      return $blocklist;
    } else {
      return false;
    }
  }
}