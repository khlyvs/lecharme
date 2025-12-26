<?php

namespace App\Http\Controllers\website\Home;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Website\Home\HomeService;

class HomeController extends Controller
{
        public function __construct(
        protected HomeService $homeService
    ) {}

        public function home(){

            $products = $this->homeService->getProducts();

            return view('website.home.home', compact('products'));

        }



}
