<?php

namespace App\Http\Controllers\User;

use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Models\UnitKerjaApik;
use App\Models\User;
use App\Models\UserMap;
use Illuminate\Http\Request;
use function back;
use function response;
use function view;

class MappingController extends Controller
{
    public function index()
    {
        $get['users'] = User::where('level_id', '2')->get();
        return view('mapping.index', $get);
    }


    public function store(Request $request)
    {
        try {
            $codes = $request->post('unit_kerja_kode');
            $units = UnitKerjaApik::whereIn('unit_kerja_kode', $codes)->get();
            $data = [];
            foreach ($units as $unit) {
                $dt['user_id'] = $request->post('user_id');
                $dt['unit_kerja_kode'] = $unit['unit_kerja_kode'];
                $dt['unit_kerja_nama'] = $unit['unit_kerja_nama'];
                $data[] = $dt;
            }
            UserMap::insert($data);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }

    public function destroy($map_id)
    {
        try {
            UserMap::destroy($map_id);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }
}
