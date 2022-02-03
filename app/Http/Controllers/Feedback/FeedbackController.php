<?php

namespace App\Http\Controllers\Feedback;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Models\ComplaintTicket;
use App\Models\FeedbackTicket;
use App\Models\UserMap;
use function redirect;
use function response;
use function view;

class FeedbackController extends Controller
{

    public function index()
    {
        $cookie = CookieHelper::logAccess()->administrator;
        $maps = UserMap::where('user_id', $cookie->id)->get();
        $codes = $maps->pluck('unit_kerja_kode');
        return view('feedback.index', [
            'complaints' => ComplaintTicket::search(request(['search']))
                ->whereIn('unit_kerja_kode', $codes)
                ->where(['ticket_posting' => 1, 'ticket_status' => 0])
                ->paginate(5)->withQueryString(),
        ]);
    }

    public function history()
    {
        $cookie = CookieHelper::logAccess()->administrator;
        $maps = UserMap::where('user_id', $cookie->id)->get();
        $codes = $maps->pluck('unit_kerja_kode');
        return view('feedback.history', [
            'complaints' => ComplaintTicket::search(request(['search']))
                ->whereIn('unit_kerja_kode', $codes)
                ->where(['ticket_posting' => 1, 'ticket_status' => 1])
                ->paginate(5)->withQueryString(),
        ]);
    }

    public function detail(ComplaintTicket $complaint_ticket)
    {
        return view('feedback.detail', [
            'complaint' => $complaint_ticket,
            'cookie' => CookieHelper::logAccess()->administrator,
            'feedbacks' => FeedbackTicket::where('ticket_code', $complaint_ticket->ticked_code)->get()
        ]);
    }

    public function store(FeedbackRequest $request)
    {
        try {
            $request['user_id'] = $request->post('user_id');
            $request['nip'] = $request->post('nip');
            FeedbackTicket::create($request->all());
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
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
