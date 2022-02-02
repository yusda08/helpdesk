<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CookieHelper;
use App\Helpers\HelperResponse;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function view;

class LoginController extends Controller
{
    private AuthService $AuthService;

    public function __construct()
    {
        $this->AuthService = new AuthService();
    }

    public function index()
    {
        $get['cookie'] = CookieHelper::logAccess();
        return view('auth.login', $get);
    }


    public function store(Request $request)
    {
        try {
            $attributes = $request->validate([
                'username' => ['required', 'min:3'],
                'password' => ['required', 'min:6']
            ]);
            return $this->AuthService->validation($attributes['username'], $attributes['password']);
        } catch (ValidationException $e) {
            return HelperResponse::getStatusFalse(message: $e->getMessage());
        }
    }

}
