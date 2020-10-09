<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopSearch extends Model
{
    use SoftDeletes;
    public $table = 'rokida_top_searchs';
}
