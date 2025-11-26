<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS - TODOS LOS ROLES
    |--------------------------------------------------------------------------
    */
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    /*
    |--------------------------------------------------------------------------
    | MOVEMENTS - COMPARTIDO ENTRE ADMIN Y NURSE
    |--------------------------------------------------------------------------
    | Ambos roles pueden usar estos métodos (index, create, store)
    | Validación de permisos se hace desde middleware en las rutas de abajo.
    |--------------------------------------------------------------------------
    */

    Route::get('movements', [InventoryMovementController::class, 'index'])->name('movements.index');
    Route::get('movements/create', [InventoryMovementController::class, 'create'])->name('movements.create');
    Route::post('movements', [InventoryMovementController::class, 'store'])->name('movements.store');

    /*
    |--------------------------------------------------------------------------
    | ADMIN - TIENE ACCESO TOTAL
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['role:admin'])
        ->group(function () {

            // Productos
            Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('products', [ProductController::class, 'store'])->name('products.store');
            Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

            // Movimientos pueden verse desde /movements
            // Usuarios
            Route::resource('users', UserController::class);
        });

    /*
    |--------------------------------------------------------------------------
    | NURSE - SOLO CREA Y VE MOVIMIENTOS
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:nurse'])->group(function () {
        // Redirige rutas nurse a las principales
        Route::get('nurse/movements', fn() => redirect()->route('movements.index'))->name('nurse.movements.index');
        Route::get('nurse/movements/create', fn() => redirect()->route('movements.create'))->name('nurse.movements.create');
        Route::post('nurse/movements', fn() => redirect()->route('movements.store'))->name('nurse.movements.store');
    });

    /*
    |--------------------------------------------------------------------------
    | DOCTOR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:doctor'])->group(function () {
        // aquí puedes agregar permisos especiales si deseas
    });

    /*
    |--------------------------------------------------------------------------
    | ASSISTANT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:assistant'])->group(function () {
        // lo mismo
    });

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | PDFS
    |--------------------------------------------------------------------------
    */
    Route::get('/pdf/stock-bajo', [PdfController::class, 'stockBajo'])->name('pdf.stock-bajo');
    Route::get('/pdf/medicamentos', [PdfController::class, 'medicamentos'])->name('pdf.medicamentos');
    Route::get('/pdf/movimientos', [PdfController::class, 'movimientosFiltrados'])->name('pdf.movimientos');

    

});

require __DIR__.'/auth.php';
