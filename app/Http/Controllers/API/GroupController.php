<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Libs\JsonUtil as Json;
use App\Libs\ApiResponseUtil as ApiResponse;

class GroupController extends BaseController
{
    function update(Request $request, $uid) {
        $active = $request->input('active');
        $groups = Json::readData4Json('groups');

        foreach ( $groups as &$item ) {
            if ($item['uid'] == $uid ) {
                $item['active'] = $active;
            }
        }

        if (! Json::writeData4Json('groups', $groups) ) {
            return ApiResponse::failure();
        }

        return ApiResponse::ok();
    }

    function search(Request $request) {
        $groups = Json::readData4Json('groups');
        return ApiResponse::ok($groups);
    }

    function searchUid(Request $request, $uid) {
        $groups = Json::readData4Json('groups');

        foreach ( $groups as $item ) {
            if ($item['uid'] == $uid ) {
                return ApiResponse::ok($item);
            }
        }

        return ApiResponse::notFound();
    }
}
