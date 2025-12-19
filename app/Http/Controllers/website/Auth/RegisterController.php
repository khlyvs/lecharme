<?php

namespace App\Http\Controllers\website\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Auth\RegisterRequest;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{



    public function index(){
        return view("website.auth.register");
    }


    public function register(RegisterRequest $request) {

        $user = User::create([
            "name"     => $request->name,
            "email"    => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return redirect()->route('login-page', ['locale' => app()->getLocale()]);
    }





}
