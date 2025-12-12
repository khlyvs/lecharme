<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Profile\ResetCredentialsRequest;

class ResetCredentialsController extends Controller
{



    public function updateCredentials(ResetCredentialsRequest $request){

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        $request->session()->regenerate();

           return redirect()->back()->with('success', 'Şifrəniz uğurla dəyişdirildi.');


    }









}
