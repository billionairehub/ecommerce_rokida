<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class Custommer extends Authenticatable implements JWtSubject
{
    use SoftDeletes;
    protected $table = 'rokida_users';

    public function getPasswordAttribute()
    {
      return $this->passwords;
    }
    public function getJWTIdentifier()
    {
       return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
       return [];
    }
}
