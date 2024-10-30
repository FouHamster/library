<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminChecker extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $role = Role::where('title', '=', 'Admin')->first();
        if (!$request->user() || $request->user()->role_id !== $role->id) {
            return response()->json(['success' => false, 'data' => 'User not is admin!'], 500);
        }

        return $next($request);
    }
}
