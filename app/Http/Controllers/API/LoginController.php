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
        $credential = [
            'email' => $req->input('email'),
            'password' => $req->input('passwords')
        ];
        if($req->email == null)
        {
            #authentication
            if (!$token = auth('api')->attempt($credentials))
            {
                #Phone or Passwords Fail
                    return response()->json([
                        'status' => false,
                        'code' => 403,
                        'message' => trans('message.check_login')
                    ],403);
            }
        }
        else 
        {
            if (!$token = auth('api')->attempt($credential))
            {
                #Phone or Passwords Fail
                    return response()->json([
                        'status' => false,
                        'code' => 403,
                        'message' => trans('message.check_login')
                    ],403);
            }
        }
        
        #Login success
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.login_success'),
            'token' => $token
        ],200);
    }

    public function getInfo()
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.get_info'),
            'token_data' => auth('api')->user()
        ],200);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.logout_success'),
            'token_data' => null
        ],200);
    }
}
