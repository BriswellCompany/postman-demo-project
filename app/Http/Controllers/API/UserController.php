<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

use App\Libs\JsonUtil as Json;
use App\Libs\ApiResponseUtil as ApiResponse;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request     $request
     * @return \Illuminate\Http\Response
     */
    function search(Request $request) {
        $users = Json::readData4Json('users');

        foreach ( $users as &$item ) {
            unset($item['password']);
        }

        return ApiResponse::ok($users);
    }

    function searchUid(Request $request, $uid) {
        $users = Json::readData4Json('users');

        foreach ( $users as $item ) {
            if ($item['uid'] == $uid ) {
                unset($item['password']);
                return ApiResponse::ok($item);
            }
        }

        return ApiResponse::notFound();
    }

    function update(Request $request, $uid) {
        $password = $request->input('password');
        $users = Json::readData4Json('users');

        foreach ( $users as &$item ) {
            if ($item['uid'] == $uid ) {
                $item['password'] = Hash::make($password);
            }
        }

        if (! Json::writeData4Json('users', $users) ) {
            return ApiResponse::failure();
        }

        return ApiResponse::ok();
    }

    function create(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $users = Json::readData4Json('users');

        $users[] = [
            'uid' => Str::uuid(),
            'username' => $username,
            'password' => Hash::make($password)
        ];

        if (! Json::writeData4Json('users', $users) ) {
            return ApiResponse::failure();
        }

        return ApiResponse::created();
    }
}
