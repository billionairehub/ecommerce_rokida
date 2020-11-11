<?php

namespace App\Http\Controllers\Backend\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Seller\TypeShippingsEloquentRepository as TypeShippingsRepo;

use Constants;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $lst = $_GET;
            $typeShipping = new TypeShippingsRepo();
            $shipping = $typeShipping->showAll($lst);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $shipping
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
        try {
            $lst = $request->all();
            $keys = $request->keys();
            $productId = $_GET;
            $typeShipping = new TypeShippingsRepo();
            $result = $typeShipping->addShippingChannels($productId['id'], $keys, $lst);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $result
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
        try {
            $lst = $_GET;
            $typeShipping = new TypeShippingsRepo();
            $result = $typeShipping->deleteShipping ($lst);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $result
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
