<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response = [
        'code' => null,
        'message' => null,
        'data' => null
    ];

    public static function Blueprint($code = null, $message = null, $data = null)
    {
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(['code' => self::$response['code'], 'message' => self::$response['message'], 'data' => self::$response['data']], self::$response['code']);
    }
}
