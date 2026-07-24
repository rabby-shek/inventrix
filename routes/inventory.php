<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockAdjustmentController;

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
            Route::get('/{product}/edit', 'edit')->name('.edit');
            Route::post('/', 'store')->name('.store');
            Route::put('/{product}', 'update')->name('.update');
            Route::delete('/{product}', 'destroy')->name('.destroy');
            Route::post('/bulk-delete', 'bulkDelete')->name('.bulkDelete');
        });
    // Brands routes
    Route::controller(BrandController::class)
        ->prefix('brands')
        ->name('brands')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store')->name('.store');
            Route::put('/{brand}', 'update')->name('.update');
            Route::delete('/{brand}', 'destroy')->name('.destroy');
            Route::post('/bulk-delete', 'bulkDelete')->name('.bulkDelete');
        });
    // Warehouses routes
    Route::controller(WarehouseController::class)
        ->prefix('warehouses')
        ->name('warehouses')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store')->name('.store');
            Route::put('/{warehouse}', 'update')->name('.update');
            Route::delete('/{warehouse}', 'destroy')->name('.destroy');
            Route::post('/bulk-delete', 'bulkDelete')->name('.bulkDelete');
        });
    // Stock routes
    Route::controller(StockController::class)
        ->prefix('stock')
        ->name('stock')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store')->name('.store');
            Route::put('/{stockItem}', 'update')->name('.update');
            Route::delete('/{stockItem}', 'destroy')->name('.destroy');
        });
    // Stock Adjustments routes
    Route::controller(StockAdjustmentController::class)
        ->prefix('stock-adjustments')
        ->name('stock-adjustments')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store')->name('.store');
            Route::delete('/{stockAdjustment}', 'destroy')->name('.destroy');
            Route::post('/bulk-delete', 'bulkDelete')->name('.bulkDelete');
        });
});
