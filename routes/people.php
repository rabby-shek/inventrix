<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::middleware('auth')->prefix('people')->name('people.')->group(function () {

    //Customer Routes
    Route::controller(CustomerController::class)
        ->prefix('customers')
        ->name('customers')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::delete('/{customer}', 'destroy');
        });
});
