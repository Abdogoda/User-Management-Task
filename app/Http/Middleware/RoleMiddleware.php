<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware{

    public function handle(Request $request, Closure $next, string $role): Response{
        if (!Auth::check() || !Auth::user()->roles->pluck('name')->contains($role)) {
            abort(403, 'Forbidden: Insufficient Role');
        }

        return $next($request);
    }
}