<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classify extends Model
{
    use SoftDeletes;
    protected $table = 'rokida_classify';
}
