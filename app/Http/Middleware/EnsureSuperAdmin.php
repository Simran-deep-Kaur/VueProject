<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->type === 'users' && !auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
