<?php

namespace App\Http\Controllers\website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Website\Auth\LoginRequest;
use App\Services\Website\Favorite\FavoriteService;

class LoginController extends Controller
{

    public function __construct(
        protected FavoriteService $favoriteService
    ) {}


    public function index()
    {
        return view("website.auth.login");
    }

    public function login(LoginRequest $request)
    {
        //  ƏVVƏL guest session id-ni saxla
        $guestSessionId = $request->session()->getId();

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {


            $request->session()->regenerate();

        //  Guestdekileri User id ye kocumek
            $this->favoriteService->mergeGuestFavorites($guestSessionId);

            return redirect()->route('dashboard', [
                'locale' => app()->getLocale()
            ]);
        }

        return back()->withErrors([
            'error' => 'Email və ya şifrə yanlışdır.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-page', [
            'locale' => app()->getLocale()
        ]);
    }
}
