<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === 'Admin' || $request->user()->role === 'SubAdmin' || $request->user()->role === 'Staff') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}