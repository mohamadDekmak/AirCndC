<?php

use App\Models\Shelter;
use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function ($locale = null) {
    // Define your default locale
    $defaultLocale = 'ar'; // Set the default locale here
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
    } else {
        app()->setLocale($defaultLocale);
        return redirect("/$defaultLocale");
    }

    $isRtl = ($locale === 'ar');
    $shelters = Shelter::whereNull('rent')->get();
    $rental_data = Shelter::whereNotNull('rent')->get();

    return view('pages.home', [
        'isRtl' => $isRtl,
        'locale' => $locale,
        'shelters' => $shelters,
        'rental_data' => $rental_data,
    ]);
});

Route::get('/admin/{locale?}' , function ($locale = null){
    $defaultLocale = 'ar';
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
    } else {
        app()->setLocale($defaultLocale);
        return redirect("/admin/$defaultLocale");
    }
    $isRtl = ($locale === 'ar');
    return view('pages.admin', ['isRtl' => $isRtl , 'locale' => $locale]);
})->name('user.index');

Route::post('/login/{locale?}' , [\App\Models\User::class , "login"])->name('user.login');
Route::post('/add/{locale?}' , [\App\Models\User::class , "store"])->name('user.store');
Route::post('/shelters/{locale?}', [\App\Models\Shelter::class, 'store'])->name('shelters.store');
