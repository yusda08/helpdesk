<?php

namespace App\Http\Controllers;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Models\ComplaintTicket;
use App\Models\UserMap;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function index()
    {
        $cookie = CookieHelper::logAccess()->administrator;
        $maps = UserMap::where('user_id', $cookie->id)->get();
        $codes = $maps->pluck('unit_kerja_kode');
        return view('feedback.index', [
            'cookie' => $cookie,
            'maps' => $maps,
            'complaints' => ComplaintTicket::whereIn('unit_kerja_kode', $codes)
                ->where(['ticket_posting' => 1, 'ticket_status' => 0])
                ->paginate(5)
        ]);
    }

    public function detail(ComplaintTicket $complaint_ticket)
    {
        return view('feedback.detail', [
            'complaint' => $complaint_ticket
        ]);
    }

    public function updateStatus(ComplaintTicket $complaint_ticket)
    {
        try {
            $complaint_ticket->update(['ticket_status' => 1]);
            $response = HelperResponse::getStatusTrue('Selesai feedback.');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return redirect(route('feedback'));
    }
}
