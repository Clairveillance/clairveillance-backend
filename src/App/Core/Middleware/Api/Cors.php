<?php

declare(strict_types=1);

namespace App\Core\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class Cors
{
    public function handle(Request $request, Closure $next): mixed
    {
        $headers = [
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Origin' => '*',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            // 'Origin' => config('app.url')
        ];

        if ($request->getMethod() == 'OPTIONS') {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
