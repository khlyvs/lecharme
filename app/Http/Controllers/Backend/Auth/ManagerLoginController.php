<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManagerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('manager.Auth.login');
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.view');
        }

        return back()->withErrors([
            'email' => 'Email və ya şifrə yanlışdır',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ backend login route
        return redirect()->route('backend.login');
    }


}
