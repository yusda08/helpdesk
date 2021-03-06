<?php

namespace App\Http\Middleware;

use App\Helpers\CookieHelper;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
//        $guards = empty($guards) ? [null] : $guards;
//
//        foreach ($guards as $guard) {
//            if (Auth::guard($guard)->check()) {
//                return redirect(RouteServiceProvider::HOME);
//            }
//        }

        if ($cookie = (array)CookieHelper::logAccess()) {
            if (array_key_exists('pegawai', $cookie)) {
                return redirect(route('complaint'));
            } elseif (array_key_exists('administrator', $cookie)) {
                return redirect(route('home'));
            } else {
                return redirect(route('logout'));
            }
        }
        return $next($request);
    }
}
