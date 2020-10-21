<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductShopCategory extends Model
{
    use SoftDeletes;
    public $table = 'rokida_product_shop_category';
}
