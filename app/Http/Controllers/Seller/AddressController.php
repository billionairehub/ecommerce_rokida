<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Functions\Seller\Addresss;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = 1;
        $success = Addresss::getAllAddress($userId);
        return $success;
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
        $userId = 1;
        $keys = $request->keys();
        $success = Addresss::addAddress($userId, $keys, $lst);
        return $success;
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
        $lst = $request->all();
        $keys = $request->keys();
        $userId = 1;
        $success = Addresss::updateAddress($userId, $keys, $lst, $id);
        if ($success == false) {
            return trans('error.is_default_pickup_return');
        }
        return $success;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = 1;
        $success = Addresss::destroy($userId, $id);
        if ($success == false) {
            return trans('error.not_found_address_or_not_delete_default');
        }
        return $success;
    }

    public function setDefault($id){
        $userId = 1;
        $success = Addresss::setDefault($userId, $id);
        if ($success == false) {
            return trans('error.not_found_address');
        }
        return $success;
    }

    public function pickup($id){
        $userId = 1;
        $success = Addresss::pickup($userId, $id);
        if ($success == false) {
            return trans('error.not_found_address');
        }
        return $success;
    }

    public function return($id){
        $userId = 1;
        $success = Addresss::return($userId, $id);
        if ($success == false) {
            return trans('error.not_found_address');
        }
        return $success;
    }
}
