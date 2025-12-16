<?php

namespace App\Http\Controllers\website\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $locale = session('locale', app()->getLocale()) ?: 'az';

        try {

            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            Auth::login($user);

            return redirect()->route('dashboard', ['locale' => $locale]);

        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());

            return redirect()->route('login-page', ['locale' => $locale])
                ->withErrors(['error' => 'Google ilə giriş uğursuz oldu.']);
        }
    }
}
