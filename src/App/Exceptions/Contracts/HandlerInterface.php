<?php

declare(strict_types=1);

namespace App\Exceptions\Contracts;

use Illuminate\Http\JsonResponse;

interface HandlerInterface
{
    public function register(): void;

    public function render($request, \Throwable $exception): JsonResponse;
}
