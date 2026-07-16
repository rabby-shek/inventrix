<?php

// Login Routes
require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/system.php';
require __DIR__.'/inventory.php';

use Illuminate\Support\Facades\Route;







Route::get('/products', function () {
    return view('inventory.products');
})->name('products');

Route::get('/products/create', function () {
    return view('inventory.add-product');
})->name('products.create');



Route::get('/brands', function () {
    return view('inventory.brands');
})->name('brands');

Route::get('/stock', function () {
    return view('inventory.stock');
})->name('stock');

Route::get('/orders', function () {
    return view('sales.orders');
})->name('orders');

Route::get('/invoices', function () {
    return view('sales.invoices');
})->name('invoices');

Route::get('/returns', function () {
    return view('sales.returns');
})->name('returns');

Route::get('/purchase-orders', function () {
    return view('purchases.purchase-orders');
})->name('purchase-orders');

Route::get('/suppliers', function () {
    return view('purchases.suppliers');
})->name('suppliers');

Route::get('/customers', function () {
    return view('people.customers');
})->name('customers');

Route::get('/expenses', function () {
    return view('finance.expenses');
})->name('expenses');

Route::get('/payments', function () {
    return view('finance.payments');
})->name('payments');

Route::get('/reports', function () {
    return view('finance.reports');
})->name('reports');

Route::get('/settings', function () {
    return view('system.settings');
})->name('settings');

Route::get('/users', function () {
    return view('system.users');
})->name('users');

Route::get('/roles', function () {
    return view('system.roles');
})->name('roles');


Route::get('/warehouses', function () {
    return view('inventory.warehouses');
})->name('warehouses');

Route::get('/stock-adjustments', function () {
    return view('inventory.stock-adjustments');
})->name('stock-adjustments');

Route::get('/shipments', function () {
    return view('sales.shipments');
})->name('shipments');

Route::get('/tax-rates', function () {
    return view('finance.tax-rates');
})->name('tax-rates');

Route::get('/activity-log', function () {
    return view('system.activity-log');
})->name('activity-log');
