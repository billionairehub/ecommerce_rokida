<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Constants;
use RecipeShipping;
use Validators;

use App\Product;
use App\Promotion;
use App\TypeShipping;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $lst = $request->all();
        $keys = $request->keys();
        $valid = true;
        if ((Validators::requiredFieldProduct($lst) === false) || (Validators::requiredFieldPromotion($lst) === false) || (Validators::requiredFieldShippingType($lst) === false))
            $valid = false;
        if ($valid == true) {
            $productId = 1;
            if (Validators::requiredFieldPromotion($lst) != null)
                $this->addPromotion($productId, $keys, $lst);
            $this->addShippingChannels($productId, $keys, $lst);
            return trans('message.add_product_success');
        } else return trans('error.not_complete_information');
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

    function addPromotion($productId, $keys, $lst) {
        $promotion = new Promotion;
        $promotion->product_id = $productId;
        foreach ($keys as $key) {
            if (in_array($key, Constants::REQUIRED_DATA_FIELD_PROMOTION) == true)
                $promotion->$key = $lst[$key];
        }
        $successPromotion = $promotion->save();
        return $successPromotion;
    }

    function addShippingChannels($productId, $keys, $lst) {
        $shippingChannels = str_replace(' ', '', $lst['shipping_channels']);
        $lstShippingChannels = explode(',', $shippingChannels);
        for ($i = 0; $i < count($lstShippingChannels); $i++) {
            $typeShipping = new TypeShipping;
            $typeShipping->product_id = $productId;
            foreach ($keys as $key) {
                if (in_array($key, Constants::REQUIRED_DATA_FIELD_TYPE_SHIPPING) == true) {
                    if ($key === 'shipping_channels')
                        $typeShipping->shipping_channels = intval($lstShippingChannels[$i]);
                    else 
                        $typeShipping->$key = $lst[$key];
                }
            }
            $typeShipping->fees = RecipeShipping::giaoHangNhanh($lst['weight'], $lst['length'], $lst['width'], $lst['height']);
            $typeShipping->save();
        }
    }
}
