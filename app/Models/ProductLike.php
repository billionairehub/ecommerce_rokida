<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLike extends Model
{
    use SoftDeletes;
    public $table = 'rokida_product_like';
}
