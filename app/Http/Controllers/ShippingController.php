<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Functions\TypeShippings;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst = $_GET;
        $shipping = TypeShippings::showAll($lst['product']);
        if ($shipping == false) {
            return trans('error.not_found_shipping');
        } else {
            return $shipping;
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
        if (array_key_exists('shipping_channels', $input) == false || $input['shipping_channels'] == null) {
            return trans('error.not_complete_information');
        }
        $add = TypeShippings::addShipping($lst, $input);
        if ($add == true) {
            return trans('message.add_type_shipping_success');
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
    public function destroy()
    {
        $lst = $_GET;
        $delete = TypeShippings::deleteShipping($lst);
        if ($delete == 0) {
            return trans('error.can_not_delete_shipping');
        } else if ($delete == 1) {
            return trans('message.delete_shipping_success');
        }
    }
}
