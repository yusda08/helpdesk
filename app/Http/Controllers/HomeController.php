<?php

namespace App\Http\Controllers;

use App\Helpers\CookieHelper;
use App\Models\UserApik;

class HomeController extends Controller
{

    private PegawaiController $Pegawai;

    public function __construct()
    {
        $this->Pegawai = new PegawaiController();
    }

    public function __invoke()
    {
        $get['cookie'] = CookieHelper::logAccess();
        return view('home', $get);
    }
}
