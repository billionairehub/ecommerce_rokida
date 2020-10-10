<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RateReviewShop extends Model
{
    use SoftDeletes;
    public $table = 'rokida_rates';
}
