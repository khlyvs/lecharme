<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Subcategory;

class LocaleController extends Controller
{
   public function switch($locale)
{
    $available = ['az', 'en', 'ru'];
    if (! in_array($locale, $available)) {
    $locale = session('locale', config('app.locale'));
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    // Əgər /-dəsənsə → /az
    if (request()->path() === '/') {
        return redirect("/{$locale}");
    }

    // Əgər /en/... , /az/... -dəsə → locale-i dəyiş
    $segments = request()->segments();

    if (in_array($segments[0] ?? null, ['az', 'en', 'ru'])) {
        $segments[0] = $locale;
        return redirect('/' . implode('/', $segments));
    }

    // fallback
    return redirect("/{$locale}");
}
}
