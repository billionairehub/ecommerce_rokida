<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Constants;
use Validators;

use App\Http\Controllers\Functions\Promotions;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst = $_GET;
        $success = Promotions::getAll($lst['product']);
        if ($success == false) {
            return trans('message.not_found_promotion');
        } else {
            return $success;
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
        $lst = $_GET;
        $input = $request->all();
        $keys = $request->keys();
        $validate = Validators::requiredFieldPromotion($input);
        if ($validate == 1) {
            $success = Promotions::addPromotion($lst['product'], $keys, $input);
            if ($success == true) {
                return trans('message.add_promotion_success');
            }
        }
        return trans('error.passed_argument_is_valid');
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
        $success = Promotions::singleDelete($id);
        if ($success == false) {
            return trans('error.delete_fail');
        } else {
            return trans('message.delete_promotion_success');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $lst = $_GET;
        $success = Promotions::delete($lst['product']);
        if ($success == false) {
            return trans('error.delete_fail');
        } else {
            return trans('message.delete_promotion_success');
        }
    }
}
