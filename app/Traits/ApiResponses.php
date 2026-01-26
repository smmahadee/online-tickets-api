<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function ok($message, $data = null): JsonResponse
    {
        return $this->success($message, $data);
    }

    protected function success($message, $data = null, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status_code' => $statusCode,
            'data' => $data,
        ], $statusCode);
    }

    protected function error($message, $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status_code' => $statusCode,
        ], $statusCode);
    }
}