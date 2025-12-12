<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{



    public function redirect(){

        return Socialite::driver("google")->redirect();
    }


    public function callback(){

            try{
            $google_user = Socialite::driver("google")->user();

            $user = User::where('google_id', $google_user->getId())->first();

            if(!$user){
                $user = User::create([
                    'name'  => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'password' => bcrypt(uniqid()), 
                    'google_id' => $google_user->getId(),
                ]);
            }

            // Mövcud user üçün də login edilməlidir
            Auth::login($user);

            return redirect()->route('dashboard');

        }catch(\Exception $e){
            dd($e->getMessage());
        }



    }



}
