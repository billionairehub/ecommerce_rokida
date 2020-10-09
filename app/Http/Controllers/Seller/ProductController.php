<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Constants;
use Validators;
use Image;

use App\Http\Controllers\Functions\Products;
use App\Http\Controllers\Functions\Promotions;
use App\Http\Controllers\Functions\TypeShippings;
use App\Http\Controllers\Functions\Classifies;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst = $_GET;
        $userId = 1;
        $product = Products::getListAll($userId, $lst);
        return $product;
    }

    public function soldout() {
        $lst = $_GET;
        $userId = 1;
        $product = Products::getListSoldout($userId, $lst);
        return $product;
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
    public function store(Request $request, Response $response)
    {
        $lst = $request->all();
        $keys = $request->keys();
        $userID = 1;
        $valid = true;
        if ((Validators::requiredFieldProduct($lst) === false) || (Validators::requiredFieldPromotion($lst) === 0) || (Validators::requiredFieldClassify($lst) == 0) || (Validators::requiredFieldShippingType($lst) === false))
            return trans('error.not_complete_information');
            
        $product = Products::addProduct($userID, $keys, $lst);
        
        $key['slug'] = str_replace(' ', '-', $product->name) . '.' . $product->id;
        $key['product_code'] = $product->id;
        $code = ['slug', 'product_code'];
        Products::updateProduct($userID, $code, $key, $product->id);
        $productId = $product->id;
        if (Validators::requiredFieldPromotion($lst) == 1)
            Promotions::addPromotion($productId, $keys, $lst);
        if (Validators::requiredFieldClassify($lst) == 1)
            Classifies::addClassify($productId, $keys, $lst);
        TypeShippings::addShippingChannels($productId, $keys, $lst);
        return trans('message.add_product_success');
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
        $userID = 1;
        $lst = $request->all();
        $keys = $request->keys();

        $successUpdate = Products::updateProduct($userID, $keys, $lst, $id);
        if ($successUpdate == false) {
            return trans('error.not_found_item');
        }
        return trans('message.update_product_success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = 1;
        $success = Products::deleteProduct($author, $id);
        if ($success == true && gettype($success) != 'string') {
            Promotions::deletePromotion($id);
            TypeShippings::deleteShippingChannel($id);
            Classifies::deleteClassify($id);
            return trans('message.delete_product_success');
        } else {
            return trans($success);
        }
    }
}
