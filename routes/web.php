<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController; 


// Ruta Principal para todos los usuarios nos manda al login en caso de no estar autenticados y si lo están al dashboard
Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    //dashboard para todos los usuarios
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // GRUPO 2: Solo Almacenistas (Protegido por rol)
    Route::middleware(['role:almacenista'])->group(function () {
        
        // Aquí van las rutas de inventario
        Route::resource('categories', CategoryController::class);
        // Route::resource('products', ProductController::class); // Descomenta cuando crees el controlador
        
    });

    // GRUPO 3: Solo Admins (Futuro)
    /*
    Route::middleware(['role:admin'])->group(function () {
        // Rutas de usuarios...
    });
    */

});