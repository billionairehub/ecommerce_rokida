<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Custommer;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        
        $credentials = [
            'phone' => $req->input('phone'),
            'password' => $req->input('passwords')
        ];
        #authentication
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
}
