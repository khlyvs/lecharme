<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

        public function home(){




            return view('website.home.home');

        }
}
