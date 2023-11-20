<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            if ($request->route()->getName() === 'show-login-admin') {
                return redirect()->route('admin-dashboard');
            }
        } else {
            if ($request->route()->getName() !== 'show-login-admin' && $request->method() !== 'POST') {
                return redirect()->route('show-login-admin');
            }
        }
        return $next($request);
    }
}
