<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    // /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if ecommerce admin is not logged in then redirect to ecommerce admin login page
        if (!$request->expectsJson() && $request->is('admin/*')) {
            // return route('ecomLogin');
            return route('ecomLogin');
        }

        if (!$request->expectsJson()) {
            return route('ecomLogin');
        }
    }
}
