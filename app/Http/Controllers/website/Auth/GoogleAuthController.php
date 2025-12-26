<?php

namespace App\Http\Controllers\website\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\Website\Favorite\FavoriteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{

    public function __construct(
        protected FavoriteService $favoriteService
    ) {}


    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $locale = session('locale', app()->getLocale()) ?: 'az';

        try {

            $googleUser = Socialite::driver('google')->user();
            $guestSessionId = session()->getId();
            $user = User::firstOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );


            Auth::login($user);

            $this->favoriteService->mergeGuestFavorites($guestSessionId);

            return redirect()->route('dashboard', ['locale' => $locale]);

        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());

            return redirect()->route('login-page', ['locale' => $locale])
                ->withErrors(['error' => 'Google ilə giriş uğursuz oldu.']);
        }
    }
}
