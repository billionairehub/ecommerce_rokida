<?php

namespace App\Http\Controllers\Backend\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Seller\ProductEloquentRepository as ProductRepo;

use Constants;
use Validators;

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
            $product = new ProductRepo();
            if ($param == Constants::LIST_ALL_PRODUCT) {
                $products = $product->getMyProduct($lst);
            } else if ($param == Constants::LIST_SOLDOUT) {
                $products = $product->getProductSoldout($lst);
            } else if ($param == Constants::PRODUCT_UNLISTED) {
                $products = $product->getProductUnlisted($lst);
            }
            return response()->json(
                [
                    'success' => true,
                    'code' => 200,
                    'data' => $products
                ],
                200
            );
        }  catch(\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'code' => 404,
                    'data' => null
                ],
                404
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHideProduct ($id) {
        try {
            $showHide = new ProductRepo();
            $success = $showHide->showHideProduct($id);
            return response()->json(
                [
                    'success' => true,
                    'code' => 200,
                    'data' => $products
                ],
                200
            );
            return $success;
        }  catch(\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'code' => 404,
                    'data' => null
                ],
                404
            );
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
        try {
            $lst = $request->all();
            $keys = $request->keys();
            $valid = true;
            if ((Validators::requiredFieldProduct($lst) === false) || (Validators::requiredFieldPromotion($lst) === 0) || (Validators::requiredFieldClassify($lst) == 0) || (Validators::requiredFieldShippingType($lst) === false)) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => 404,
                        'data' => null
                    ],
                    404
                );
            }
            $addProduct = new ProductRepo();
            $product = $addProduct->addProduct($keys, $lst);
            return response()->json(
                [
                    'success' => true,
                    'code' => 200,
                    'data' => $product
                ],
                200
            );
        }  catch(\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'code' => 404,
                    'data' => null
                ],
                404
            );
        }
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
        try {
            $lst = $request->all();
            $keys = $request->keys();
            $updateProduct = new ProductRepo();
            $successUpdate = $updateProduct->updateProduct($keys, $lst, $id);
            if ($successUpdate == false) {
                return response()->json(
                    [
                        'success' => false,
                        'code' => 404,
                        'data' => null
                    ],
                    404
                );
            }
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $successUpdate
                ],
                200
            );
        }  catch(\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'code' => 404,
                    'data' => null
                ],
                404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleteProduct = new ProductRepo();
            $delete = $deleteProduct->deleteProduct($id);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $delete
                ],
                200
            );
        } catch(\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'code' => 404,
                    'data' => null
                ],
                404
            );
        }
    }
}
