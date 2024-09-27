<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $currentUser = Auth::user();
            $routeUser = $request->route('user'); // Assumes route model binding

            // If the user is an admin, allow access to all user profiles
            if ($currentUser->role === 'admin') {
                return $next($request);
            }

            // If the route user is the authenticated user, allow access
            if ($routeUser instanceof \App\Models\User && $routeUser->id === $currentUser->id) {
                return $next($request);
            }
        }

        return abort(403, 'Unauthorized action.'); // Deny access if not authorized
    }
}
