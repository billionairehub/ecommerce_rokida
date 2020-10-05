<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classify extends Model
{
    use SoftDeletes;
    public $table = 'rokida_classify';
}
