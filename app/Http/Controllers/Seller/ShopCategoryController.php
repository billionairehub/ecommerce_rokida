<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Functions\Seller\ShopCategories;

class ShopCategoryController extends Controller
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
        $data = ShopCategories::getAllCategory($userId, $lst);
        return $data;
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
        $success = ShopCategories::addCategory($userId, $lst);
        if ($success == false) {
            return trans('error.not_complete_information');
        }
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
        $lst = $_GET;
        $userId = 1;
        $success = ShopCategories::getCategory($userId, $lst, $id);
        return $success;
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
        $userId = 1;
        $success = ShopCategories::editCategory($userId, $lst, $id);
        if ($success == false) {
            return trans('error.not_found_category');
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
        $success = ShopCategories::deleteCategory($userId, $id);
        if ($success == false) {
            return trans('error.not_found_category');
        }
        return $success;
    }

    public function showCategory ($id) {
        $userId = 1;
        $success = ShopCategories::showCategory($userId, $id);
        if ($success == 1) {
            return trans('message.show_category_success');
        } else if ($success == -1) {
            return trans('error.not_found_category');
        } else if ($success == 0) {
            return trans('error.you_can_not_show_category');
        }
    }
    public function hideCategory ($id) {
        $userId = 1;
        $success = ShopCategories::hideCategory($userId, $id);
        if ($success == false) {
            return trans('error.not_found_category');
        }
        return $success;
    }

    public function addProduct (Request $request, $id) {
        $lst = $request->all();
        $userId = 1;
        $success = ShopCategories::addProduct($userId, $id, $lst);
        if ($success == 2) {
            return trans('error.not_found_category');
        } else if ($success == 3) {
            return trans('error.product_exists_in_category');
        } else if ($success == 4) {
            return trans('error.not_found_item');
        }
        return trans('message.add_product_success');
    }
}
