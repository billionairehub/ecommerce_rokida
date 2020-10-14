<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    public $table = 'rokida_categories';

	public function childs() {
        return $this->hasMany('App\Category','cate_parent','id') ;
    }
    

}
