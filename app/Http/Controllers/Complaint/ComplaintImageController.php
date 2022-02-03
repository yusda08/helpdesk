<?php

namespace App\Http\Controllers\Complaint;

use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintImageRequest;
use App\Models\ComplaintImage;
use Illuminate\Support\Facades\Storage;
use function back;
use function response;

class ComplaintImageController extends Controller
{

    public final function loadComplaintImages($ticket_code)
    {
        try {
            $data = ComplaintImage::where('ticket_code', $ticket_code)->get();
            $response = HelperResponse::getStatusTrue(message: 'success', data: json_decode($data, true));
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }

    public final function store(ComplaintImageRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
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

    public final function destroy(ComplaintImage $images)
    {
        try {
//            echo json_encode($images);
//            die();
            $bool = (bool)ComplaintImage::destroy($images['image_id']);
            if (!$bool) throw new \Exception('Gagal Menghapus Data');
            Storage::delete($images->file_image);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Throwable $th) {
            $response = HelperResponse::getStatusFalse($th->getMessage());
        }
        return response()->json($response);
    }

}
