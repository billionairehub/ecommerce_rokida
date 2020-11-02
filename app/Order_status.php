<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_status extends Model
{
    use SoftDeletes;
    public $table = 'rokida_status_orders';
}
