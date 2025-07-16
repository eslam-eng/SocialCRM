<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => []
        ], $code);
    }

    public static function error(string $message = 'Error', $errors = [], int $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], $code);
    }

    public static function badRequest(string $message = 'Bad Request', $errors = []): JsonResponse
    {
        return self::error($message, $errors, 400);
    }

    public static function notFound(string $message = 'Resource Not Found', $errors = []): JsonResponse
    {
        return self::error($message, $errors, 404);
    }

    public static function unauthorized(string $message = 'Unauthorized', $errors = []): JsonResponse
    {
        return self::error($message, $errors, 401);
    }

    public static function forbidden(string $message = 'Forbidden', $errors = []): JsonResponse
    {
        return self::error($message, $errors, 403);
    }
}
