<?php

declare(strict_types=1);

namespace Infrastructure\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    private static array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    public static function handle($data, null|int $status = null, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            data: $data,
            status: $status ?? 200,
            headers: array_merge(static::$headers),
        );
    }
}
