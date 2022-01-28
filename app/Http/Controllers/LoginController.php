<?php

namespace App\Http\Controllers;

use App\Helpers\HelperResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    private Client $client;
    private PegawaiController $pegawai;

    public function __construct()
    {
        $this->pegawai = new PegawaiController();
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function index()
    {
        return view('auth.login');
    }

    public final function sso(string $username, string $password): array
    {
        try {
            $res = $this->client->request('POST', 'https://simpeg.kalselprov.go.id/api/sso', [
                'form_params' => ['passcode' => $username, 'user_login' => $password]
            ]);
            $data = json_decode($res->getBody()->getContents(), true);
            $response = HelperResponse::getStatusTrue(message: 'Success', data: $data);
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse(message: $exception->getMessage());
        }
        return $response;
    }

    public function store(Request $request)
    {
        try {
            $attributes = $request->validate([
                'username' => ['required', 'min:3'],
                'password' => ['required', 'min:6']
            ]);
            $sso = $this->sso($attributes['username'], $attributes['password']);
            echo json_encode($sso);
            die();
            if ($sso['data']) {
                if (!$sso['data']['status']) return HelperResponse::getStatusFalse(message: 'failed to login, please check your username and password.!!!');
                $session = $this->_loginService($sso['data']['nip']);
                echo json_encode($session);
                die();
                return HelperResponse::getStatusTrue(message: 'Success');
            } else {
                if (!Auth::attempt($attributes)) return HelperResponse::getStatusFalse(message: 'failed to login, please check your username and password.!!!');
                return HelperResponse::getStatusTrue(message: 'Success');
            }
        } catch (ValidationException $e) {
            return HelperResponse::getStatusFalse(message: $e->getMessage());
        }
    }

    private function _loginService(string $nip)
    {
        $pegawai = $this->pegawai->getApiPegawai($nip);
        return $pegawai['data'];
    }
}
