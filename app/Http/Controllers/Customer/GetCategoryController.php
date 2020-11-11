<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\CategoriesEloquentRepository as CategoriesRepo;

class GetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductCategories()
    {
        try {
            $categories = new CategoriesRepo();
            $productCategories = $categories->getProductCategories();
            return $productCategories;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetailCategory($slug)
    {
        try {
            $categories = new CategoriesRepo();
            $productCategories = $categories->getDetailCategory($slug);
            return $productCategories;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }
}
