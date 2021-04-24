<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            return $next($request);
        } else if (Auth::guard($guard)->check()) {
            dd('???');
            return redirect()->route('admin.question.index');
        } else {
            return redirect()->route('admin.login');
        }

        // return $next($request);
    }
}
