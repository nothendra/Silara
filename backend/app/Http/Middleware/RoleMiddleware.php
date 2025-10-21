<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Cek apakah user memiliki role yang sesuai
        if ($request->user()->role !== $role) {
            return response()->json(['message' => 'Forbidden. Role required: ' . $role], 403);
        }

        return $next($request);
    }
}