<?php

namespace App\Libs;

use Firebase\JWT\JWT;
use Illuminate\Support\Str;

class ApiJwtAuthUtil
{

    public static function generateJwtToken($uid)
    {
        $jwt_payload_json = sprintf('{"uid":"%s"}', $uid);
        $jwt_token = JWT::encode($jwt_payload_json, 'private_key_hs256', 'HS256');

        return $jwt_token;
    }

    public static function getJwtToken($request)
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public static function decodeJwtToken($jwt_token)
    {
        $payload_json = JWT::decode($jwt_token, 'private_key_hs256', array('HS256'));
        $payload_array = json_decode($payload_json, true);

        return $payload_array;
    }

    public static function getUserId($payload)
    {
        $user_id = $payload['uid'];
        return $user_id;
    }
}
