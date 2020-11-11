<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\User\DetailProductEloquentRepository as DetailRepo;

class DetailProController extends Controller
{
    public function getdetailPro()
    {
        try {
            $lst = $_GET;
            $deatailProduct = new DetailRepo();
            $deatailProducts = $deatailProduct->getdetailPro($lst);
            return $deatailProducts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function addShoppingCart(Request $req, $slug)
    {
        try {
            $lst = $req->all();
            $deatailProduct = new DetailRepo();
            $deatailProducts = $deatailProduct->addShoppingCart($lst, $slug);
            return $deatailProducts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }
}
