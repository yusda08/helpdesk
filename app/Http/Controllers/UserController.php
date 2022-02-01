<?php

namespace App\Http\Controllers;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $get['level_id'] = request()->get('level');
        $get['levels'] = UserLevel::all();
        $get['users'] = User::where('level_id', $get['level_id'])->get();
        $get['cookie'] = CookieHelper::logAccess();
        return view('user.index', $get);
    }

    public function store(UserRequest $request)
    {
        try {
            User::create($request->all());
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }

    public function resetPassword($id)
    {
        try {
            $data = ['password' => Hash::make('123456')];
            User::where('id', $id)->update($data);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }

    public function updateStatus(User $user)
    {
        try {
            $isActive = $user->is_active == 0 ? 1 : 0;
            $data = ['is_active' => $isActive];
            $user->update($data);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public final function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            User::destroy($id);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        return response()->json($response);
    }
}
