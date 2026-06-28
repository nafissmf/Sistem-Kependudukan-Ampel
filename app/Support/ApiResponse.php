<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

/**
 * Format response REST API mengikuti dokumen "REST API STANDARD":
 *   sukses -> { success: true, message, data }
 *   error  -> { success: false, message, errors }
 */
class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $status);
    }

    public static function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $status);
    }

    public static function notFound(string $resource = 'Data'): JsonResponse
    {
        return self::error("{$resource} tidak ditemukan.", 404);
    }

    public static function conflict(string $message): JsonResponse
    {
        return self::error($message, 409);
    }

    public static function forbidden(): JsonResponse
    {
        return self::error('Anda tidak memiliki izin untuk aksi ini.', 403);
    }
}
