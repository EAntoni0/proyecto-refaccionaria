<?php

namespace App\Http\Controllers\Warehouseman;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        return view('warehouseman.inventory.index');
    }

    // metodo para añadir nuevo stock
    // ... método index arriba ...

    public function addStock(Request $request, $productId)
{
    // 1. Quitamos la validación de 'notes'
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($productId);

    \Illuminate\Support\Facades\DB::transaction(function () use ($request, $product) {
        
        // 2. Quitamos 'notes' del create
        \App\Models\InventoryMovement::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'type' => 'entrada',
            'quantity' => $request->quantity,
            // 'notes' => $request->notes,  <-- BORRADO
        ]);

        $product->increment('stock', $request->quantity);
    });

    return redirect()->route('warehouseman.inventory.index')
        ->with('success', 'Stock agregado correctamente.');
}
}
