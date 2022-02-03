<?php

namespace App\Http\Controllers\Utility;

use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Models\UserApik;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use function response;

class PegawaiController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://simpeg.kalselprov.go.id/api/',
            'verify' => false,
        ]);
    }

    public final function getApiPegawai(string $nip): array
    {
        try {
            $get = $this->client->get('identitas', [
                'query' => ['nip' => $nip]
            ]);
            $getPegawaiAPI = json_decode($get->getBody(), true);
            return HelperResponse::getStatusTrue(message: 'Success', data: $getPegawaiAPI);
        } catch (GuzzleException $e) {
            return HelperResponse::getStatusFalse(message: $e->getMessage());
        }
    }

    public final function loadPegawai(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = $request->post('search');
        $getData = UserApik::where('nip', 'like', "%$search%")->get();
        foreach ($getData as $i => $r) {
            $getData[$i]['id'] = $r['nip'];
            $getData[$i]['text'] = $r['nip'];
        }
        $select['total_count'] = count($getData);
        $select['items'] = $getData;
        return response()->json($select);
    }

    public function resetAccount(Request $request)
    {
        try {
            $nip = $request->post('nip');
            UserApik::where("nip", $nip)->update(['uuid' => null]);
            return HelperResponse::statusAction('Update Berhasil.', true);
        } catch (\Exception $e) {
            return HelperResponse::statusAction($e->getMessage(), false);
        }
    }


}
