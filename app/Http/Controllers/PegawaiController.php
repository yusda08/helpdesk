<?php

namespace App\Http\Controllers;

use App\Helpers\HelperResponse;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{

    public function loadPegawai(Request $request)
    {
        $search = $request->post('search');
        $getData = Pegawai::where('nip', 'like', "%$search%")
            ->orWhere('pegawai_nama', 'like', "%$search%")->get();
        foreach ($getData as $i => $r) {
            $getData[$i]['id'] = $r['nip'];
            $getData[$i]['text'] = $r['pegawai_nama'] . ' - (' . $r['nip'] . ')';
        }
        $select['total_count'] = count($getData);
        $select['items'] = $getData;
        return response()->json($select);
    }

}
