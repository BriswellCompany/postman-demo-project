<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\SignatureInvalidException;
use App\Libs\ApiJwtAuthUtil as ApiJwtAuth;
use App\Libs\JsonUtil as Json;
use App\Libs\ApiResponseUtil as ApiResponse;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwt_token = ApiJwtAuth::getJwtToken($request);
        try {
            $auth_payload = ApiJwtAuth::decodeJwtToken($jwt_token);
            $uid = ApiJwtAuth::getUserId($auth_payload);

            $user = null;

            $users = Json::readData4Json('users');
            foreach ( $users as $item ) {
                if ($item['uid'] == $uid ) {
                    $user = $item;
                }
            }

            if ( !$user ) {
                throw new \Exception();
            }

        } catch (SignatureInvalidException | \Exception  $e) {
            return ApiResponse::unauthorized();
        }

        return $next($request);
    }

    function readData4Json($secion) {
        $jsonString = file_get_contents(base_path("resources/json/{$secion}.json"));

        return json_decode($jsonString, true);
    }
}
