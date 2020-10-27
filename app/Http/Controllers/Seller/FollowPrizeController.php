<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Functions\Seller\FollowPrizzes;

class FollowPrizeController extends Controller
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
        $success = FollowPrizzes::listFollowPrizze ($userId, $lst);
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
        $userId = 1;
        $lst = $request->all();
        $keys = $request->keys();
        $success = FollowPrizzes::addFollowPrizze($userId, $keys, $lst);
        if (gettype($success) == 'string') {
            return trans($success);
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

    public function dashboard () {
        $lst = $_GET;
        $userId = 1;
        $success = FollowPrizzes::dashboard($userId, $lst);
        $success = json_decode($success, true);
        return $success;
    }
}
