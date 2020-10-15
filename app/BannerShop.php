<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerShop extends Model
{
    use SoftDeletes;
    public $table = 'rokida_banners';
}
