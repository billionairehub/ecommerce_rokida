<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeShipping extends Model
{
    use SoftDeletes;
    public $table = 'rokida_type_shipping';
}
