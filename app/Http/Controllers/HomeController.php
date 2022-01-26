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
        return view('home');
    }
}
