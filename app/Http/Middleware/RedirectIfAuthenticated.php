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
        //如果是已经验证的，就直接跳转到home
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        //未验证的话就继续请求
        return $next($request);
    }
}
