<?php

namespace App\Http\Controllers\Utility;

use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Models\UnitKerjaApik;
use App\Models\UserMap;
use function response;

class UnitController extends Controller
{

    public function loadUnit()
    {
        try {
            $maps = UserMap::all();
            $codes = $maps->pluck('unit_kerja_kode');
            $units = UnitKerjaApik::whereRaw('LENGTH(unit_kerja_kode) <= 2')->whereNotIn('unit_kerja_kode', $codes)->get();
            $data = json_decode($units, true);
            $response = HelperResponse::getStatusFalse(message: 'Success', data: $data);
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }
}
