<?php

namespace App\Http\Controllers\Backend\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Seller\PromotionEloquentRepository as PromotionRepo;

use Validators;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $lst = $_GET['product'];
            $promotion = new PromotionRepo();
            $product = $promotion->getAllPromotion($lst);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $product
                ],
                200
            );
        } catch(\Exception $e) {
            return response()->json(
                [
                    'success'   => false,
                    'code'      => 404,
                    'data'      => null
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
        try{
            $productId = $_GET['product'];
            $lst = $request->all();
            $keys = $request->keys();
            $validate = Validators::requiredFieldPromotion($lst);
            if ($validate == 1) {
                $promotion = new PromotionRepo();
                $success = $promotion->addPromotion($productId, $keys, $lst);
                return response()->json(
                    [
                        'success'   => true,
                        'code'      => 200,
                        'data'      => $success
                    ],
                    200
                );
            }
            return response()->json(
                [
                    'success'   => false,
                    'code'      => 400,
                    'message'   => trans('error.not_complete_information'),
                    'data'      => null
                ],
                400
            );
        } catch(\Exception $e) {
            return response()->json(
                [
                    'success'   => false,
                    'code'      => 404,
                    'data'      => null
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
        try {
            $promotion = new PromotionRepo();
            $success = $promotion->singleDelete($id);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $success
                ],
                200
            );
        } catch(\Exception $e) {
            return response()->json(
                [
                    'success'   => false,
                    'code'      => 404,
                    'data'      => null
                ],
                404
            );
        }
    }

    public function delete($product)
    {
        try {
            $promotion = new PromotionRepo();
            $success = $promotion->delete($product);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $success
                ],
                200
            );
        } catch(\Exception $e) {
            return response()->json(
                [
                    'success'   => false,
                    'code'      => 404,
                    'data'      => null
                ],
                404
            );
        }
    }
}
