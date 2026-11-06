<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Mendukung autentikasi via guard admin maupun guard web dengan role admin
        if ($role === 'admin' && (auth()->guard('admin')->check() || ($request->user() && $request->user()->role === 'admin'))) {
            return $next($request);
        }

        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
