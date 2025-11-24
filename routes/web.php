<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ADMIN
    Route::middleware(['role:admin'])->group(function () {

        // Productos
        Route::resource('products', ProductController::class);

        // Movimientos ADMIN (URL diferente para evitar choques)
        Route::get('admin/movements', [InventoryMovementController::class, 'index'])->name('admin.movements.index');
        Route::get('admin/movements/create', [InventoryMovementController::class, 'create'])->name('admin.movements.create');
        Route::post('admin/movements', [InventoryMovementController::class, 'store'])->name('admin.movements.store');

        // Usuarios
       Route::prefix('admin')
        ->name('admin.')
        ->middleware(['role:admin'])
        ->group(function () {
            Route::resource('users', UserController::class);
        });

    });

    // NURSE
    Route::middleware(['role:nurse'])->group(function () {
        Route::get('nurse/movements', [InventoryMovementController::class, 'index'])->name('nurse.movements.index');
        Route::get('nurse/movements/create', [InventoryMovementController::class, 'create'])->name('nurse.movements.create');
        Route::post('nurse/movements', [InventoryMovementController::class, 'store'])->name('nurse.movements.store');
    });


    // DOCTOR
    Route::middleware(['role:doctor'])->group(function () {
        Route::resource('products', ProductController::class)->only(['index', 'show']);
    });


    // ASSISTANT
    Route::middleware(['role:assistant'])->group(function () {
        Route::resource('products', ProductController::class)->only(['index']);
    });


    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
