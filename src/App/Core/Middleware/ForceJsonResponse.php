<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use Closure;
use Illuminate\Http\Request;

final class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        return $next($request);
    }
}
