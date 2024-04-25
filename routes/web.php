<?php

use App\Http\Controllers\ProfileController;
use Core\Auth\Enums\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/product/create', function () {
    return view('admin.product.create');
})->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.create');

Route::get('/product/{product}/edit', function (\App\Models\Product $product) {
    return view('admin.product.edit', [
        'product' => $product,
        'inventory' => $product->inventory,
    ]);
})->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
