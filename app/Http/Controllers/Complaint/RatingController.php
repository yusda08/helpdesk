<?php

namespace App\Http\Controllers\Complaint;

use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Models\RatingStar;
use App\Models\RatingTicket;
use Illuminate\Http\Request;
use function back;

class RatingController extends Controller
{

    public function store(Request $request)
    {
        try {
            $attr = $request->validate([
                'ticket_code' => 'required',
                'rating_desc' => 'required',
                'rating_star' => 'required',
            ]);
            RatingTicket::create($attr);
            $response = HelperResponse::getStatusTrue('Success add data Rating.');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }
}
