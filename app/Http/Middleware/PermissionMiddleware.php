<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('permission:tenant.view')
     *                  ->middleware('permission:tenant.create,tenant.edit')
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        // Must be logged in
        if (!Auth::check()) {
            return redirect('/')->withErrors(['email' => 'Please login to continue.']);
        }

        $user = Auth::user();

        // Super admin bypasses all permission checks
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has ANY of the required permissions
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        // No permission matched
        return redirect()->back()
            ->withErrors(['error' => 'You do not have permission to perform this action.']);
    }
}
