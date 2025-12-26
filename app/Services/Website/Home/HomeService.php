<?php
namespace App\Services\Website\Home;

use App\Interfaces\Website\Home\HomeInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;




class HomeService  {


    public function __construct( private  HomeInterface $homeRepository){


    }

     public function getProducts(): Collection
    {
        return Cache::remember('home.products', 600, function () {
            return $this->homeRepository->getProducts();
        });
    }
}




