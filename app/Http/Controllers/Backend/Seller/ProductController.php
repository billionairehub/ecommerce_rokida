<?php

namespace App\Http\Controllers\Backend\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductEloquentRepository as ProductRepo;

use Constants;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($param)
    {
        try {
            $lst = $_GET;
            $user_id = 1;
            $lst['user_id'] = $user_id;
            $product = new ProductRepo();
            if ($param == Constants::LIST_ALL_PRODUCT) {
                $products = $product->getMyProduct($lst);
            } else if ($param == Constants::LIST_SOLDOUT) {
                $products = $product->getProductSoldout($lst);
            } else if ($param == Constants::PRODUCT_UNLISTED) {
                $products = $product->getProductUnlisted($lst);
            }
            return $products;
        }  catch(\Exception $e) {
            abort(400);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHideProduct ($id) {
        try {
            $userId = 1;
            $showHide = new ProductRepo();
            $success = $showHide->showHideProduct($userId, $id);
            return $success;
        }  catch(\Exception $e) {
            abort(400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
