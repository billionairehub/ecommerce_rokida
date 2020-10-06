<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Functions\Users;
use App\Http\Controllers\Functions\Phones;

use Validators;

use App\User;

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
    public function login(Request $req)
    {
        $credentials = [
            'email' => $req->input('email'),
            'password' => $req->input('passwords')
        ];
        
        if (!$token = auth('api')->attempt($credentials))
        {
            #Username or Passwords Fail
                return response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => trans('message.check_login')
                ],403);
        }

        #Login success
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.login_success'),
            'token' => $token
        ],200);
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
        else if (Phones::checkExists($lst) == false) {
            return trans('error.user_exists');
        } else {
            $user = Users::register($lst, $keys);
            $phone = Phones::register($lst, $keys, $user);
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
}
