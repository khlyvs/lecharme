<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{

        

    public function index(){
        return view("website.auth.login");

    }

    public function login(LoginRequest $request)
{
    $credentials = $request->only("email", "password");

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route("dashboard");
    }

    // Login failed
    return back()->withErrors([
        'error' => 'Email və ya şifrə yanlışdır.',
    ])->withInput();
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login-page');
}

}
