<?php

namespace App\Libs;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseUtil
{
    public static function ok($rows = '', $count = 0)
    {
        $response = response($rows, Response::HTTP_OK);

        if (is_array($rows) && $count > 0) {
            $response->header('X-Total-Count', $count);
        }

        return $response;
    }

    public static function created($content = null)
    {
        return response($content, Response::HTTP_CREATED);
    }

    public static function failure($content = null)
    {
        return response($content, Response::HTTP_FORBIDDEN);
    }

    public static function notFound()
    {
        return response(null, Response::HTTP_NOT_FOUND);
    }

    public static function unauthorized()
    {
        return response('', Response::HTTP_UNAUTHORIZED);
    }
}
