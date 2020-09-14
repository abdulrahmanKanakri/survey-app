<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('dashboard.auth.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect()
                ->intended(route('dashboard.home'))
                ->with('status', [
                    'type' => 'success',
                    'msg' => 'Successfully Logged-in'
                ]);
        }
        return redirect()->back()->with('error', 'The credentials do not match our credentials');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('dashboard.home');
    }
}
