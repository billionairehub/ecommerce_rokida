<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Functions\Seller\Users;
use App\Http\Controllers\Functions\Seller\Phones;

use Validators;

use App\Models\User;

class UserController extends Controller
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
     * Show the form for login a account resource.
     *
     * @return \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        // $lst = $request->all();
        // $keys = $request->keys();
        // $valid = Validators::requiredFieldLogin($lst, $keys);
        // if ($valid == false) {
        //     return trans('error.not_complete_information');
        // } else {
        //     Users::login($lst, $keys);
        // }
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
        $keys = $request->keys();
        
        if ((Validators::requiredFieldUser($lst) === false) || (Validators::requiredFieldPhone($lst) === false)) {
            return trans('error.not_complete_information');
        } 
        else if (Users::checkExists($lst) == false) {
            return trans('error.user_exists');
        } else {
            $user = Users::register($lst, $keys);
            return trans('message.register_success');
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
    public function destroy($id)
    {
        //
    }

    public function updateProfile (Request $request) {
        $lst = $request->all();
        $keys = $request->keys();
        $userId = 1;
        $user = Users::updateProfile($userId, $lst, $keys);
        if (gettype($user) == 'string') {
            return trans($user);
        } else if ($user == false) {
            return trans('error.server_error');
        } else {
            // return trans('message.update_user_success');
            return $user;
        }
    }
    
    public function changePhone (Request $request) {
        $lst = $request->all();
        $userId = 1;
        $user = Users::changePhone($userId, $lst);
        if (gettype($user) == 'string') {
            return trans($user);
        } else if ($user == false) {
            return trans('error.server_error');
        } else {
            return $user;
        }
    }
    
    public function changeMail (Request $request) {
        $lst = $request->all();
        $userId = 1;
        $user = Users::changeMail($userId, $lst);
        if (gettype($user) == 'string') {
            return trans($user);
        } else if ($user == false) {
            return trans('error.server_error');
        } else {
            return $user;
        }
    }
    
    public function changePassword (Request $request) {
        $lst = $request->all();
        $userId = 1;
        $user = Users::changePassword($userId, $lst);
        if (gettype($user) == 'string') {
            return trans($user);
        } else if ($user == false) {
            return trans('error.server_error');
        } else {
            return $user;
        }
    }
}
