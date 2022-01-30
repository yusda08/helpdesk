<?php

namespace App\Http\Controllers;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Http\Requests\ComplaintRequest;
use App\Models\ComplaintTickets;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{

    public function index()
    {

        $pegawai = CookieHelper::logAccess()->pegawai;
        return view('complaint', [
            'complaints' => ComplaintTickets::search(request(['search']))->where(['nip' => $pegawai->nip])->latest()->get(),
            'pegawai' => $pegawai
        ]);
    }

    public function store(ComplaintRequest $request)
    {
        try {
            $data = $request->all();
            $data['ticket_code'] = Str::upper(Str::random(10));
            $data['ticket_date'] = date("Y-m-d H:i:s");
            ComplaintTickets::create($data);
            $response = HelperResponse::getStatusTrue('Success add data complaint.');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusTrue($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }

    public final function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $ticket_id = $request->post('ticket_id');
            ComplaintTickets::where('ticket_id', $ticket_id)->delete();
            $response = HelperResponse::getStatusTrue('Success deleted data.');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusTrue($exception->getMessage());
        }
        return response()->json($response);
    }
}
