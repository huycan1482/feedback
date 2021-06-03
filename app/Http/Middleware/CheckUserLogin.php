<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserLogin 
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
        $role_ids = Role::whereIn('name', ['user', 'teacher'])->get('id');

        if (Auth::check()) {
            foreach ($role_ids as $item) {
                if ($item->id == Auth::user()->role_id) {
                    return $next($request);
                }
            }
            return redirect()->route('user.login');
        } else {
            return redirect()->route('user.login');
        }     
    }
}
