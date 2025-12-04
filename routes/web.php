<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Admin\SaleController as AdminSaleController;
use App\Http\Controllers\Seller\SaleController as SellerSaleController;

// Otros controladores
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Warehouseman\InventoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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


    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'almacenista') {
            return redirect()->route('warehouseman.dashboard');
        } elseif ($user->role === 'vendedor') {
            return redirect()->route('seller.dashboard');
        }
        return abort(403, 'Rol no asignado.');
    })->name('dashboard');


    // rutas del admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('dashboard'); // Resultado: admin.dashboard

        Route::resource('users', UserController::class);
        

        Route::get('/sales', [AdminSaleController::class, 'index'])->name('sales.index');

        Route::resource('categories', CategoryController::class);        

        Route::resource('products', ProductController::class);
    });


    // rutas del almacenista
    Route::middleware(['role:almacenista'])->prefix('warehouseman')->name('warehouseman.')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('warehouseman.dashboard'); 
        })->name('dashboard');

        // Ver inventario
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    
    // Ruta para procesar el formulario de añadir stock
    Route::post('/inventory/{product}/add', [InventoryController::class, 'addStock'])->name('inventory.add');
    });


    // rutas del vendedor
    Route::middleware(['role:vendedor'])->prefix('seller')->name('seller.')->group(function () {

        Route::redirect('/', 'seller/dashboard');
        
        Route::get('/dashboard', function () {
            return view('seller.dashboard'); 
        })->name('dashboard'); // Resultado: seller.dashboard
        

        Route::get('/sales', [SellerSaleController::class, 'index'])->name('sales.index');

    });

});