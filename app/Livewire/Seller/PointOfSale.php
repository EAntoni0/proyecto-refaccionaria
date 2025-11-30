<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Para transacciones

class PointOfSale extends Component
{
    public $search = ''; // Buscador
    public $cart = [];   // Carrito de compras
    public $total = 0;   // Total a pagar

    // Escuchar el evento de búsqueda
    public function render()
    {
        // Buscar productos que coincidan con el nombre
        $products = Product::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->take(10) // Solo mostramos 10 para no saturar
            ->get();

        return view('livewire.seller.point-of-sale', compact('products'));
    }

    // Agregar producto al carrito
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->stock <= 0) {
            $this->alertError('Producto sin stock o no encontrado');
            return;
        }

        // Si ya está en el carrito, aumentamos cantidad
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            // Si no, lo agregamos nuevo
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'max_stock' => $product->stock
            ];
        }

        $this->calculateTotal();
    }

    // Eliminar del carrito
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateTotal();
    }

    // Calcular el total $$
    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
    }

    // COMPLETAR VENTA
    public function saveSale()
    {
        if (empty($this->cart)) {
            return;
        }

        // Usamos DB::transaction para que todo se guarde o nada (seguridad)
        DB::transaction(function () {
            
            // 1. Crear la Venta (Encabezado)
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total' => $this->total,
                'status' => 'completed'
            ]);

            // 2. Guardar Detalles y Restar Stock
            foreach ($this->cart as $item) {
                // Guardar detalle
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Restar del inventario
                $product = Product::find($item['id']);
                $product->decrement('stock', $item['quantity']);
            }
        });

        // Limpiar todo y avisar
        $this->cart = [];
        $this->total = 0;
        $this->search = '';
        
        // Disparar alerta de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Venta Exitosa!',
            'text' => 'El inventario ha sido actualizado.'
        ]);
        
        return redirect()->route('seller.dashboard');
    }

    // Ayuda para alerta de error
    public function alertError($msg)
    {
        $this->dispatch('swal', [
            'icon' => 'error',
            'title' => 'Error',
            'text' => $msg
        ]);
    }
}