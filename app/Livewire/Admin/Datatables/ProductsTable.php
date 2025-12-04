<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // Alineación vertical centrada para que la imagen se vea bien
        $this->setTdAttributes(function(Column $column, $row, $columnIndex, $rowIndex) {
            return ['class' => 'align-middle'];
        });
    }

    public function builder(): Builder
    {
        // 1. Cargamos la categoría
        // 2. CORRECCIÓN IMPORTANTE: Ordenamos por 'products.created_at' para evitar error de ambigüedad
        return Product::query()
            ->with('category')
            ->orderBy('products.created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->sortable(),

            // --- AQUÍ ESTÁ LA MAGIA DE LA FOTO ---
            Column::make("Imagen", "image_path") 
                ->label(function($row) {
                    
                    // DEPURACIÓN (Borrar después):
                    // Si esto imprime NULL en pantalla, la tabla no está seleccionando el campo.
                    // if (!$row->image_path) dump('El campo está vacío');

                    if ($row->image_path) {
                        $url = asset('storage/' . $row->image_path);
                        return '<img src="'.$url.'" alt="img" class="w-10 h-10 rounded-full object-cover">';
                    }
                    
                    return '<span class="text-xs text-gray-400">Sin foto</span>';
                })
                ->html(),

            Column::make("Nombre", "name")
                ->searchable()
                ->sortable()
                ->format(function($value, $row) {
                    return '<div>
                                <div class="font-bold">'.$value.'</div>
                                <div class="text-xs text-gray-500">Slug: '.$row->slug.'</div>
                            </div>';
                })
                ->html(),

            Column::make("Categoría", "category.name")
                ->searchable()
                ->sortable(),

            Column::make("Precio", "price")
                ->sortable()
                ->format(fn($value) => '$ ' . number_format($value, 2)),

            Column::make("Stock", "stock")
                ->sortable()
                ->format(function($value) {
                    if($value == 0) return '<span class="text-red-500 font-bold">Agotado</span>';
                    return $value . ' un.';
                })
                ->html(),

            Column::make("Acciones")
                ->label(
                    fn($row) => view('admin.products.actions', ['product' => $row])->render()
                )
                ->html(),
        ];
    }
}