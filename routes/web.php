<?php

use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Core\Auth\Enums\UserRole;
use Core\Product\Controllers\API\ProductController;
use Core\Sales\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->as('admin.products.')
    ->prefix('/products')
    ->group(function () {

        Route::get(
            uri: '/',
            action: [ProductController::class, 'index']
        )->name('index');

        Route::get(
            uri: '/create',
            action: [ProductController::class, 'create']
        )->name('create');

        Route::post(
            uri: '/',
            action: [ProductController::class, 'store']
        )->name('store');

        Route::get(
            uri: '/{product}/edit',
            action: [ProductController::class, 'edit']
        )->name('edit');

        Route::patch(
            uri: '/{product}',
            action: [ProductController::class, 'update']
        )->name('update');

    });

Route::middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value . '|' . UserRole::CASHIER->value])
    ->as('admin.sales.')
    ->prefix('/sales')
    ->group(function () {

        Route::get(
            uri: '/',
            action: [SalesController::class, 'index']
        )->name('index');

        Route::get(
            uri: '/create',
            action: [SalesController::class, 'create']
        )->name('create');

    });

Route::middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value . '|' . UserRole::CASHIER->value])
    ->group(function () {
        Route::get(
            uri: '/pos',
            action: [SalesController::class, 'pos']
        )->name('pos');

    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
