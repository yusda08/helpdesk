<?php

namespace App\Http\Controllers;

use App\Helpers\HelperResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        try {
            $attributes = $request->validate([
                'username' => ['required', 'alpha_num', 'min:3'],
                'password' => ['required', 'min:6']
            ]);
            if (!Auth::attempt($attributes)) return HelperResponse::getStatusFalse(message: 'failed to login, please check your username and password.!!!');
            return HelperResponse::getStatusTrue(message: 'Success');
        } catch (ValidationException $e) {
            return HelperResponse::getStatusFalse(message: $e->getMessage());
        }
    }
}
