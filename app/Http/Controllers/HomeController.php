<?php

namespace App\Http\Controllers;

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

        $get['pegawai'] = $this->Pegawai->getApiPegawai('198505152008031001');
        $get['user_apik'] = UserApik::all();
        return view('home', $get);
    }
}
