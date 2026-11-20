<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated with the 'franchise' guard
        if (Auth::guard('customer')->check()) {
            // The user is authenticated, proceed with the request
            return $next($request);
        }

        // The user is not authenticated, redirect to the login page or show an error
        return redirect()->route('shop.login');
    }
}
