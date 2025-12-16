<?php

namespace App\Http\Controllers\website\Home;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

        public function home(){

            return view('website.home.home');

        }


        public function test() {
          return $azer= Category::create([
                'name_az' =>'Kosmetika',
                'name_en'=>'Cosmetics',
                'name_ru' =>'Косметика',
                'is_active' =>1,
                'position'=>3,
                'slug_az'=>'Kosmetika',
                'slug_en'=>'Cosmetics',
                'slug_ru'=>'Косметика',
            ]);

        }
}
