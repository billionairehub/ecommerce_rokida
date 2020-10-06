<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validators;

use App\Http\Controllers\Functions\Classifies;

class ClassifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst = $_GET;
        $success = Classifies::getAll($lst['product']);
        if ($success == false) {
            return trans('message.not_found_classify');
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
        $classify = Classifies::addClassify($lst['product'], $keys, $input);
        if ($classify ==  true) {
            return trans('message.add_classify_success');
        } else {
            return trans('error.classify_same');
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
        $input = $request->all();
        $success = Classifies::update($id, $input);
        if ($success == false) {
            return trans('error.update_classify_fail');
        } else {
            return trans('message.update_classify_success');
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
        $success = Classifies::singleDelete($id);
        if ($success == false) {
            return trans('error.delete_fail');
        } else {
            return trans('message.delete_classify_success');
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
        $success = Classifies::delete($lst['product']);
        if ($success == false) {
            return trans('error.delete_fail');
        } else {
            return trans('message.delete_classify_success');
        }
    }
}
