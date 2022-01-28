<?php

namespace App\Http\Middleware;

use App\Helpers\CookieHelper;
use Closure;
use Illuminate\Http\Request;

class IsLogged
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($cookie = (array)CookieHelper::logAccess()) {
            if (array_key_exists('pegawai', $cookie)) {
                redirect(route('complaint'));
            } elseif (array_key_exists('administrator', $cookie)) {
                redirect(route('home'));
            } else {
                return redirect(route('login'));
            }
            return $next($request);
        }
        return redirect(route('login'));
    }
}
