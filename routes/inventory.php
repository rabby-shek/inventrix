<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware('auth')->prefix('inventory')->name('inventory.')->group(function () {

    // Category Routes
    Route::controller(CategoryController::class)
        ->prefix('categories')
        ->name('categories.')
        ->group(function () {
            Route::get('/categories', 'index');
            Route::post('/categories',  'store')->name('store');
            Route::put('/categories/{category}',  'update')->name('update');
            Route::delete('/categories/{category}', 'destroy')->name('destroy');
            Route::post('/categories/bulk-delete', 'bulkDelete')->name('bulkDelete');
        });
});
