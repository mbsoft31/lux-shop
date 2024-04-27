<?php

use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Core\Auth\Enums\UserRole;
use Core\Product\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.products.index');

Route::get('/product/create', function () {
    return view('admin.product.create');
})->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.create');

Route::post('/product', [ProductController::class, 'store'])
    ->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.store');

Route::patch('/product/{product}', [ProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.update');

/*Route::get('/product/{product}', function (\App\Models\Product $product) {
    return view('admin.product.show', [
        'product' => $product,
        'inventory' => $product->inventory,
    ]);
})->middleware(['auth', 'verified', 'role:'. UserRole::ADMINISTRATOR->value])
    ->name('admin.product.show');*/

Route::get('/product/{product}/edit', function (Product $product) {
    // TODO: implement javascript for the form to function properly
    // TODO: implement the form to update the product
    // TODO: implement the form to update the inventory items
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
