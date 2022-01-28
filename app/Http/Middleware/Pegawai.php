<?php

namespace App\Http\Middleware;

use App\Helpers\CookieHelper;
use Closure;
use Illuminate\Http\Request;

class Pegawai
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
        $cookie = (array)CookieHelper::logAccess();
        if (array_key_exists('pegawai', $cookie)) {
            return $next($request);
        }
        return redirect(route('login'));
    }
}
