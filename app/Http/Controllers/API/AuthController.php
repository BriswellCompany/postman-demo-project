<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

use App\Libs\JsonUtil as Json;
use App\Libs\ApiJwtAuthUtil as ApiJwtAuth;
use App\Libs\ApiResponseUtil as ApiResponse;

class AuthController extends BaseController
{
    function auth(Request $request)
    {
        $username = $request->input('username');
        $login_pass = $request->input('password');
        $users = Json::readData4Json('users');

        $user = null;
        foreach ($users as $item) {
            if ($item['username'] == $username) {
                $user = $item;
            }
        }

        if ($user == null) {
            return ApiResponse::unauthorized();
        }

        $is_valid_pass = Hash::check($login_pass, $user['password']);

        if (!$is_valid_pass) {
            return ApiResponse::unauthorized();
        }

        unset($user['password']);

        $jwt_tokens = [
            'token_type' => 'Bearer',
            'expires_in' => 3599,
            'ext_expires_in' => 3599,
            'access_token' => ApiJwtAuth::generateJwtToken($user['uid']),
            'user' => $user
        ];

        return ApiResponse::ok($jwt_tokens);
    }
}
