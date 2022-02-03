<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use function response;

class LogoutController extends Controller
{


    public function __invoke()
    {
        try {
//            Auth::logout();
//            Cookie::unqueue(CookieHelper::$keyCookie);
            $cookie1 = Cookie::forget(CookieHelper::$keyCookie);
            $cookie2 = Cookie::forget('laravel_session');
            $cookie3 = Cookie::forget('XSRF-TOKEN');
            $response = HelperResponse::getStatusTrue('Success');
            return response()->json($response)
                ->withCookie($cookie1);
        } catch (\Exception $e) {
            $response = HelperResponse::getStatusFalse($e->getMessage());
            return response()->json($response);
        }
    }
}
