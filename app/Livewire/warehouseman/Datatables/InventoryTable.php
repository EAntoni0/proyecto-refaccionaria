<?php

namespace App\Livewire\Warehouseman\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product; // Usamos el modelo Product
use Illuminate\Database\Eloquent\Builder;

class InventoryTable extends DataTableComponent
{
    // Configuración básica de la tabla
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // Opcional: Establecer un mensaje cuando no hay productos
        $this->setEmptyMessage('No se encontraron productos en el inventario.');
    }

    // La consulta a la base de datos
    public function builder(): Builder
    {
        // Simplemente traemos todos los productos ordenados por los creados más recientemente
        return Product::query()->orderBy('created_at', 'desc');
    }

    // Definición de Columnas
    public function columns(): array
    {
        return [

            Column::make("ID", "id")->sortable(),

            // 2. NOMBRE DEL PRODUCTO
            Column::make("Producto", "name")
                ->sortable()
                ->searchable(),

            // 3. STOCK ACTUAL (Con colores de alerta)
            Column::make("Stock", "stock")
                ->sortable()
                ->format(function($value) {
                    if ($value <= 5) {
                        // Rojo si es crítico (5 o menos)
                        return '<span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">'.$value.' Crítico</span>';
                    } elseif ($value <= 15) {
                        // Amarillo si es bajo
                        return '<span class="px-2 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full">'.$value.' Bajo</span>';
                    }
                    // Verde si está bien
                    return '<span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">'.$value.' Unidades</span>';
                })
                ->html(), // Importante para que renderice el HTML del span

            // 4. PRECIO (Informativo, el almacenista no lo edita)
            Column::make("Precio", "price")
                ->sortable()
                ->format(fn($value) => '$ ' . number_format($value, 2)),

            // 5. ACCIONES (Formulario de Entrada)
            // Usamos 'label' porque no viene de la BD directamente
            Column::make("Registrar Entrada")
    ->label(function($row) {
        $url = route('warehouseman.inventory.add', ['product' => $row->id]);
        $csrf = csrf_token();
        
        return '
            <form action="'.$url.'" method="POST" class="flex items-center space-x-2">
                <input type="hidden" name="_token" value="'.$csrf.'">
                

                <input type="number" name="quantity" min="1" placeholder="Cant." 
                       class="w-24 py-1 px-2 rounded border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs transition duration-150">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </form>
        ';
    })
    ->html(),
        ];
    }
}