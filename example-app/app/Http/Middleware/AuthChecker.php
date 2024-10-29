<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthChecker extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$request->user()) {
            return response()->json(['success' => false, 'data' => 'User Unauthorized!'], 500);
        }

        return $next($request);
    }
}
