<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data, $statusCode = 200) : JsonResponse
    {
        return response()->json(
            [
                'status_code' => $statusCode,
                'message'     => 'success',
                'data'        => $data
            ],
            $statusCode
        );
    }

    public static function error($message, $statusCode = 500) : JsonResponse
    {
        return response()->json(
            [
                'status_code' => $statusCode,
                'message'     => $message,
            ],
            $statusCode
        );
    }

    public static function unauthorized() : JsonResponse
    {
        return response()->json(
            [
                'status_code' => 401,
                'message'     => 'Unauthorized access',
            ],
            401
        );
    }
}