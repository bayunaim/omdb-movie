<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login
Route::get('/', fn () => redirect()->route('login'));

// Auth routes
Auth::routes();

// Custom route login dengan rate limit (3 attempts per 1 menit)
Route::post('login', 'Auth\LoginController@login')
    ->middleware('throttle:3,1')
    ->name('login');

// Localization switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang');

// Halaman home setelah login
Route::get('/home', 'HomeController@index')->name('home');

// Group route yang butuh autentikasi
Route::middleware('auth')->group(function () {
    // Movie routes
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', 'MovieController@index')->name('index');
        Route::get('/{id}', 'MovieController@show')->name('show');
    });

    // Favorite routes
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', 'FavoriteController@index')->name('index');
        Route::post('/', 'FavoriteController@store')->name('store');
        Route::delete('/{id}', 'FavoriteController@destroy')->name('destroy');
    });
});
