<?php

namespace App\Http\Controllers\Backend\Seller;

use Constants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\InfringesEloquentRepository as InfringeRepo;

class ProductBandedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($param)
    {
        try {
            $lst = $_GET;
            $user_id = 1;
            $lst['user_id'] = $user_id;
            $infringe = new InfringeRepo();
            if ($param == Constants::BANDED_PRODUCT) {
                $infringes = $infringe->getListAll($lst);
            } else if ($param == Constants::HISTORY_BANDED_PRODUCT) {
                $infringes = $infringe->getListHistory($lst);
            }
            return $infringes;
        } catch(\Exception $e) {
            abort(400);
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
        //
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
}
