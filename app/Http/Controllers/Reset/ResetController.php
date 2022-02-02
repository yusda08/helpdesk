<?php

namespace App\Http\Controllers\Reset;

use App\Helpers\CookieHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class ResetController extends Controller
{

    public function __invoke(Request $request)
    {
        $get['cookie'] = CookieHelper::logAccess();
        return view('reset.index', $get);
    }
}
