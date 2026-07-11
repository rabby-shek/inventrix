<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/categories', function () {
    return view('categories');
})->name('categories');

Route::get('/brands', function () {
    return view('brands');
})->name('brands');

Route::get('/stock', function () {
    return view('stock');
})->name('stock');

Route::get('/orders', function () {
    return view('orders');
})->name('orders');

Route::get('/invoices', function () {
    return view('invoices');
})->name('invoices');

Route::get('/returns', function () {
    return view('returns');
})->name('returns');

Route::get('/purchase-orders', function () {
    return view('purchase-orders');
})->name('purchase-orders');

Route::get('/suppliers', function () {
    return view('suppliers');
})->name('suppliers');

Route::get('/customers', function () {
    return view('customers');
})->name('customers');

Route::get('/expenses', function () {
    return view('expenses');
})->name('expenses');

Route::get('/payments', function () {
    return view('payments');
})->name('payments');

Route::get('/reports', function () {
    return view('reports');
})->name('reports');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::get('/roles', function () {
    return view('roles');
})->name('roles');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/warehouses', function () {
    return view('warehouses');
})->name('warehouses');

Route::get('/stock-adjustments', function () {
    return view('stock-adjustments');
})->name('stock-adjustments');

Route::get('/shipments', function () {
    return view('shipments');
})->name('shipments');

Route::get('/tax-rates', function () {
    return view('tax-rates');
})->name('tax-rates');

Route::get('/activity-log', function () {
    return view('activity-log');
})->name('activity-log');
