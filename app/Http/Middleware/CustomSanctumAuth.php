<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomSanctumAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error' => 'Token not provided',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Invalid or expired token',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}