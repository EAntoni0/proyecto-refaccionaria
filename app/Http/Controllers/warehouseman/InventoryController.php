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
        $products = Product::select('id', 'name', 'stock', 'sku')->paginate(10);
        return view('warehouseman.inventory.index', compact('products'));
    }

    // metodo para añadir nuevo stock
    public function addStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($productId);

        // Usamos una transacción para asegurar que todo se guarde o nada
        DB::transaction(function () use ($request, $product) {
            
            // 1. Crear el registro en el historial (Kardex)
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(), // El Almacenista logueado
                'type' => 'entrada',
                'quantity' => $request->quantity,
                'notes' => $request->notes,
            ]);

            // 2. Actualizar el stock total del producto
            $product->increment('stock', $request->quantity);
        });

        return redirect()->back()->with('success', 'Stock agregado correctamente.');
    }
}
