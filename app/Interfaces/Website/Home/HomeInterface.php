<?php

namespace App\Interfaces\Website\Home;

use Illuminate\Support\Collection;



interface HomeInterface {


    public function getProducts(): Collection ;

}
