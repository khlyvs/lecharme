<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    protected array $allowed = ['az','en','ru'];

    public function switch($locale)
    {
        if (!in_array($locale, $this->allowed)) {
            return Redirect::back();
        }

       
        Session::put('locale', $locale);


        return Redirect::back();
    }
}
