<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

// This Class For Response Result To return Success or error based on status comes from api
class ResponsHelper
{

    // This Function To return Success result
    public static function success($data = "Successfully", string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    // This Function To return Error result
    public static function error($data, string $message = 'Error', int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
