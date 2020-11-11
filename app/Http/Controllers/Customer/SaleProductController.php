<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\ProductEloquentRepository as ProductRepo;

class SaleProductController extends Controller
{
    public static function getSaleProduct()
    {
        try {
            $sale_product = new ProductRepo();
            $sale_products = $sale_product->getSaleProduct();
            return $sale_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }
}
