<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
    }
    public function show()
    {
        return view('Backend.Auth.login', [
            'title' => 'Login to Admin Panel'
        ]);
    }

    public function login(LoginRequest $request)
    {
        $rememberMe = false;
        if ($request->input('remember_me') == 1) {
            $rememberMe = true;
        }
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $rememberMe)) {
            $request->session()->regenerate();
            return redirect()->route('admin-dashboard');
        }
        return redirect()->back()->withErrors([
            'login' => 'Email hoặc password của bạn không đúng',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('show-login-admin');
    }
}
