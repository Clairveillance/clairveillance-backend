<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use Closure;
use Illuminate\Http\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // header("Access-Control-Allow-Origin: *");

        $headers = [
            'Accept' => 'application/json',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Origin' => '*',
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
