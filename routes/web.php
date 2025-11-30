<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Importamos los controladores específicos del Almacenista
use App\Http\Controllers\warehouseman\CategoryController;
use App\Http\Controllers\warehouseman\ProductController;

// Si tienes un UserController para admin, descomenta la siguiente línea:
use App\Http\Controllers\Admin\UserController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. LA ROTONDA (Ruta /dashboard genérica)
    // Redirige al usuario a su panel correspondiente según su rol.
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        elseif ($user->role === 'almacenista') {
            return redirect()->route('warehouseman.dashboard');
        } 
        elseif ($user->role === 'vendedor') {
            return redirect()->route('seller.dashboard');
        }

        // Si no tiene rol válido
        return abort(403, 'Rol no asignado o no autorizado.');
    })->name('dashboard');


    // 2. ZONA ADMIN
    // Prefijo URL: /admin | Prefijo Nombre: admin.
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Al estar dentro del grupo 'admin.', el nombre final es 'admin.dashboard'
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('dashboard');

        // Ejemplo de rutas de usuarios (descomentar cuando tengas el controlador)
        Route::resource('users', UserController::class);
    });


    // 3. ZONA ALMACENISTA
    // Prefijo URL: /warehouseman | Prefijo Nombre: warehouseman.
    Route::middleware(['role:almacenista'])->prefix('warehouseman')->name('warehouseman.')->group(function () {
        
        // Nombre final: 'warehouseman.dashboard'
        Route::get('/dashboard', function () {
            return view('warehouseman.dashboard'); 
        })->name('dashboard');

        // Rutas del CRUD
        // Nombre final: 'warehouseman.categories.index', etc.
        Route::resource('categories', CategoryController::class);
        
        // Nombre final: 'warehouseman.products.index', etc.
        Route::resource('products', ProductController::class);
    });


    // 4. ZONA VENDEDOR
    // Prefijo URL: /seller
    Route::middleware(['role:vendedor'])->prefix('seller')->group(function () {

        //ponemos esto en caso de que solo pongamos seller. asi no da error, nos lleva a dashboard de las 2 formas
        Route::redirect('/','seller/dashboard');
        
        Route::get('/dashboard', function () {
            return view('seller.dashboard'); 
        })->name('seller.dashboard');
        
        // Aquí irían las rutas de ventas...
        Route::get('/sales', [\App\Http\Controllers\Seller\SaleController::class, 'index'])
            ->name('seller.sales.index');
    });

});