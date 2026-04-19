<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TenantSessionAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow admin to view tenant dashboard
        if (Auth::check()) {
            return $next($request);
        }

        // Allow tenant session
        if (session()->has('tenant_id')) {
            return $next($request);
        }

        return redirect('/')->withErrors(['email' => 'Please login to continue.']);
    }
}