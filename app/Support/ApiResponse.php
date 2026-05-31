<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(
        string $message,
        mixed $data = null,
        int $status = 200,
        array $extra = []
    ): JsonResponse {
        $payload = array_merge([
            'success' => true,
            'message' => $message,
        ], $extra);

        if ($data !== null) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $status);
    }

    public static function error(
        string $message,
        mixed $errors = null,
        int $status = 400
    ): JsonResponse {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
