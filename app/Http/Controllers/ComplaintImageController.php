<?php

namespace App\Http\Controllers;

use App\Helpers\HelperResponse;
use App\Models\ComplaintImage;
use Illuminate\Http\Request;

class ComplaintImageController extends Controller
{

    public function loadComplaintImages(ComplaintImage $complaint_image)
    {
        $images = $complaint_image::all();
        echo json_encode($images);
        die();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ticket_code' => 'required',
                'image' => 'required|image|file|max:4096'
            ]);
            $data['file_image'] = $request->file('image')->store('complaint-images');
            $data['ticket_code'] = $request->post('ticket_code');
            ComplaintImage::create($data);
            $response = HelperResponse::getStatusTrue('Success input images.');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }

}
