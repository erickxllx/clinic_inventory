<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth'])->group(function () {

    // Dashboard visible para todos
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ADMIN — acceso total
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('movements', InventoryMovementController::class);
    });

    // NURSE — solo movimientos
    Route::middleware(['role:nurse'])->group(function () {
        Route::resource('movements', InventoryMovementController::class)->only(['index', 'create', 'store']);
    });

    // DOCTOR — solo lectura
    Route::middleware(['role:doctor'])->group(function () {
        Route::resource('products', ProductController::class)->only(['index', 'show']);
    });

    // ASSISTANT — solo lectura básica
    Route::middleware(['role:assistant'])->group(function () {
        Route::resource('products', ProductController::class)->only(['index']);
    });

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //Vista solo para admin
    Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', UserController::class);
});
});

require __DIR__.'/auth.php';
