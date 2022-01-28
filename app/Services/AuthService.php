<?php

namespace App\Services;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Helpers\JwtHelper;
use App\Http\Controllers\PegawaiController;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class AuthService
{

    private Client $client;
    private PegawaiController $Pegawai;
    private int|float $minutes;

    public function __construct()
    {
        $this->minutes = (60 * 60 * 24 * 2);
        $this->Pegawai = new PegawaiController();
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public final function validation(string $username, string $password)
    {
        $sso = $this->sso($username, $password);
        if ($sso['data']) {
            if (!$sso['data']['status']) return HelperResponse::getStatusFalse(message: 'failed to login, please check your username and password.!!!');
            $dataPegawai = $this->Pegawai->getApiPegawai($sso['data']['nip']);
            $data = ['pegawai' => $dataPegawai['data'][0]];
        } else {
            $data = User::where('username', $username)->first();
            if (!password_verify($password, $data['password'])) return HelperResponse::getStatusFalse(message: 'failed to login, please check your username and password.!!!');
            $data = [
                'administrator' => [
                    'username' => $username,
                    'id' => $data['id'],
                    'level_id' => $data['level_id'],
                    'name' => $data['name']
                ]
            ];
        }
        $jwt = JwtHelper::encodeJwt($data);
        Cookie::queue(CookieHelper::$keyCookie, $jwt, $this->minutes);
        return HelperResponse::getStatusTrue('Login Berhasil');
    }


    private function sso(string $username, string $password): array
    {
        try {
            $res = $this->client->request('POST', 'https://simpeg.kalselprov.go.id/api/sso', [
                'form_params' => ['passcode' => $password, 'user_login' => $username]
            ]);
            $data = json_decode($res->getBody()->getContents(), true);
            if (!$data['status']) return HelperResponse::getStatusFalse(message: 'Failed !!!');
            $response = HelperResponse::getStatusTrue(message: 'Success', data: $data);
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse(message: $exception->getMessage());
        } catch (GuzzleException $e) {
            $response = HelperResponse::getStatusFalse(message: $e->getMessage());
        }
        return $response;
    }
}
