<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('system')->name('system')->group(function() {
    Route::get('/profile', function () {
        return view('system.profile');
    })->name('profile');
});
