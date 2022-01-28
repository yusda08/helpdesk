<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class CookieHelper
{
    public static string $keyCookie = 'helpdesk-apik-cookie';

    public static final function logAccess(): object|array
    {
        try {
            $token = Cookie::get(self::$keyCookie) ?? '';
            if (!$token) return [];
            return JwtHelper::decodeJwt($token);
        } catch (\Exception $exception) {
//            Cookie::forget(self::$keyCookie);
//            return redirect(route('login'));
            return [];
        }
    }

    public static function check(): bool
    {
        try {
            $jwt = self::logAccess();
            if (!$jwt) return false;
            return true;
        } catch (\Exception $th) {
            return false;
        }
    }

}
