<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error($message = 'Error', $status = 400, $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
