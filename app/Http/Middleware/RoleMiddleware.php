<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user has the required role
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // If not, return an access denied response
            return response()->json(['message' => 'Access Denied! You do not have the required permissions.'], 403);
        }

        // If the user has the required role, proceed with the request
        return $next($request);
    }
}
