<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


     public function index()
    {
        $user = Auth::user();
        return view('website.profile.index', compact('user'));
    }


    

}
