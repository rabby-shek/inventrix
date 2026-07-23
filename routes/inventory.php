<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::middleware('auth')->prefix('inventory')->name('inventory.')->group(function () {
    // Category Routes
    Route::controller(CategoryController::class)
        ->prefix('categories')
        ->name('categories')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/',  'store')->name('.store');
            Route::put('/{category}',  'update')->name('.update');
            Route::delete('/{category}', 'destroy')->name('.destroy');
            Route::post('/bulk-delete', 'bulkDelete')->name('.bulkDelete');
        });
    // Products routes
    Route::controller(ProductController::class)
        ->prefix('products')
        ->name('products')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/add', 'add')->name('.add');
            Route::post('/', 'store')->name('.store');
        });
});
