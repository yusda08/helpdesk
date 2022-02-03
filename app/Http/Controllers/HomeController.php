<?php

namespace App\Http\Controllers;

use App\Helpers\CookieHelper;
use App\Models\UserApik;
use App\Models\UserMap;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function __invoke()
    {
        $get['cookie'] = CookieHelper::logAccess();
        $administrator = $get['cookie']->administrator;
        if ($administrator->level_id === 1) {
            $get['maps'] = UserMap::all();
        } elseif ($administrator->level_id === 2) {
            $get['maps'] = UserMap::where('user_id', $administrator->id)->get();
        }
        return view('home.admin', $get);
    }
}
