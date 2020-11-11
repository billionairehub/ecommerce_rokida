<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\TopSearch;
use App\TypeShipping;
use App\Category;
use App\Repositories\User\ProductEloquentRepository as ProductRepo;

class SearchProductController extends Controller
{
    public function searchProduct()
    {
        try {
            $key = $_GET;
            $sale_product = new ProductRepo();
            $sale_products = $sale_product->searchProduct($key);
            return $sale_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function TopProducts()
    {
        try {
            $sale_product = new ProductRepo();
            $sale_products = $sale_product->TopProducts();
            return $sale_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function TopKeySearch()
    {
        try {
            $sale_product = new ProductRepo();
            $sale_products = $sale_product->TopKeySearch();
            return $sale_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

}
