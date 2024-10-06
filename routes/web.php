<?php

use App\Models\Shelter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function ($locale = null , $login = null) {
    $defaultLocale = 'ar';
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
        'login' =>  $login
    ]);
})->name('home');

Route::get('/admin/{locale?}' , function ($locale = null){
    $defaultLocale = 'ar';
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
    } else {
        app()->setLocale($defaultLocale);
        return redirect("/admin/$defaultLocale");
    }
    $shelters = Shelter::where('user_id', Auth::id())->get();
    $isRtl = ($locale === 'ar');
    return view('pages.admin', ['isRtl' => $isRtl , 'locale' => $locale , 'shelters' => $shelters]);
})->name('user.index');

Route::post('/login/{locale?}' , [\App\Models\User::class , "login"])->name('user.login');
Route::post('/add/{locale?}' , [\App\Models\User::class , "store"])->name('user.store');
Route::post('/shelters/{locale?}', [\App\Models\Shelter::class, 'store'])->name('shelters.store');
Route::delete('/function/{id}//{locale?}', [\App\Models\Shelter::class, 'destroy'])->name('function.destroy');
Route::post('/editForm/{id}//{locale?}',[\App\Models\Shelter::class, 'edit'])->name('updateData');
