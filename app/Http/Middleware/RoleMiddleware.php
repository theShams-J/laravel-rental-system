<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:super_admin')
     *                  ->middleware('role:admin')
     *                  ->middleware('role:super_admin,admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Must be logged in
        if (!Auth::check()) {
            return redirect('/')->withErrors(['email' => 'Please login to continue.']);
        }

        $user = Auth::user();

        // Must be active
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // Check if user's role matches any of the allowed roles
        if (!in_array($user->role?->name, $roles)) {
            // If admin tries to access super_admin routes → redirect to their dashboard
            if ($user->role?->name === 'admin') {
                return redirect()->route('home')
                    ->withErrors(['error' => 'You do not have permission to access that page.']);
            }

            // Fallback
            return redirect('/')->withErrors(['error' => 'Access denied.']);
        }

        return $next($request);
    }
}
