<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingChannel extends Model
{
    use SoftDeletes;
    public $table = 'rokida_shipping_channels';
}
