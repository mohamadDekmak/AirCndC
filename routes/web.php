<?php

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

    return view('pages.home');
});
