<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\RatingEloquentRepository as RateRepo;

class RatingController extends Controller
{
    public function AddRateProduct(Request $req, $id)
    {
        try {
            $lst = $req->all();
            $rating_product = new RateRepo();
            $rating_products = $rating_product->AddRateProduct($lst, $id);
            return $rating_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function UpdateRateProduct(Request $req, $id)
    {
        try {
            $lst = $req->all();
            $rating_product = new RateRepo();
            $rating_products = $rating_product->UpdateRateProduct($lst, $id);
            return $rating_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function DeleteRate($id)
    {
        try {
            $rating_product = new RateRepo();
            $rating_products = $rating_product->DeleteRate($id);
            return $rating_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function GetRateProduct($slug)
    {
        try {
            $lst = $_GET;
            $rating_product = new RateRepo();
            $rating_products = $rating_product->GetRateProduct($slug, $lst);
            return $rating_products;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }
}
