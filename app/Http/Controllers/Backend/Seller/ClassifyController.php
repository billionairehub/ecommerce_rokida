<?php

namespace App\Http\Controllers\Backend\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Seller\ClassifyEloquentRepository as ClassifyRepo;

class ClassifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        try {
            $classify = new ClassifyRepo();
            $success = $classify->getAllClassify($product);
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
            $idProduct = $_GET['product'];
            $lst = $request->all();
            $keys = $request->keys();
            $classify = new ClassifyRepo();
            $success = $classify->addClassify($idProduct, $keys, $lst);
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
        // try {
            $lst = $request->all();
            $classify = new ClassifyRepo();
            $success = $classify->update($id, $lst);
            return response()->json(
                [
                    'success'   => true,
                    'code'      => 200,
                    'data'      => $success
                ],
                200
            );
        // } catch(\Exception $e) {
        //     return response()->json(
        //         [
        //             'success'   => false,
        //             'code'      => 404,
        //             'data'      => null
        //         ],
        //         404
        //     );
        // }
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
            $classify = new ClassifyRepo();
            $success = $classify->singleDelete($id);
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
            $classify = new ClassifyRepo();
            $success = $classify->delete($product);
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
