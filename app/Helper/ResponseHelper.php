<?php

namespace App\Helper;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Return a new JSON response for a successful request.
     *
     * @param string $status
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return response
     */

    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return a new JSON response for a failed request.
     *
     * @param string $status
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */

    public static function error($status = 'error', $message = null, $statusCode = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $statusCode);
    }
}
