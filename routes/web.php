<?php

use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function ($locale = null) {
    // Define your default locale
    $defaultLocale = 'en'; // Set the default locale here

    // Check if a locale was provided and if it is valid
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
    } else {
        // If no valid locale is provided, set the default locale
        app()->setLocale($defaultLocale);
        // Optionally redirect to the default locale URL
        return redirect("/$defaultLocale");
    }

    return view('pages.home');
});
