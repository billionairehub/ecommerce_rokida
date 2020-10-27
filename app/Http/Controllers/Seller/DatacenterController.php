<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Functions\Seller\Datacenters;

class DatacenterController extends Controller
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

    public function dashboard()
    {
        $lst = $_GET;
        $userId = 1;
        $success = Datacenters::dashboard($userId, $lst);
        $success = json_decode($success, true);
        return $success;
    }

    public function productStatisticsOverview()
    {
        $lst = $_GET;
        $userId = 1;
        $success = Datacenters::productStatisticsOverview($userId, $lst);
        $success = json_decode($success, true);
        return $success;
    }

    public function productStatisticsPerformance()
    {
        $lst = $_GET;
        $userId = 1;
        $success = Datacenters::productStatisticsPerformance($userId, $lst);
        return $success;
    }

    public function salesOverview()
    {
        $lst = $_GET;
        $userId = 1;
        $success = Datacenters::salesOverview($userId, $lst);
        $success = json_decode($success, true);
        return $success;
    }

    public function chat()
    {
        $lst = $_GET;
        $userId = 1;
        $success = Datacenters::chat($userId, $lst);
        $success = json_decode($success, true);
        return $success;
    }
}
