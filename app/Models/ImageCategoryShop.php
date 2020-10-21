<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageCategoryShop extends Model
{
    use SoftDeletes;
    public $table = 'rokida_image_category_shop';
}
