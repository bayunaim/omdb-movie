<?php

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang');

Route::middleware('auth')->group(function () {
    Route::get('/movies', 'MovieController@index')->name('movies.index');
    Route::get('/movies/{id}', 'MovieController@show')->name('movies.show');

    Route::get('/favorites', 'FavoriteController@index')->name('favorites.index');
    Route::post('/favorites', 'FavoriteController@store')->name('favorites.store');
    Route::delete('/favorites/{id}', 'FavoriteController@destroy')->name('favorites.destroy');
});
