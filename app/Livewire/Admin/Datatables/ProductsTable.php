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

            Column::make("Nombre", "name")
                ->searchable()
                ->sortable()
                ->format(function($value, $row) {
                    return '<div>
                                <div class="font-bold">'.$value.'</div>
                            </div>';
                })
                ->html(),

            Column::make("Descripción", "description")
                ->searchable()
                ->format(function($value) {
                    // Usamos Str::limit para que si es muy largo no rompa la tabla (máx 50 caracteres)
                    // Y ponemos un 'title' para que al pasar el mouse se vea completo.
                    return '<span title="'.$value.'" class="text-sm text-gray-600">' 
                            . \Illuminate\Support\Str::limit($value, 50) . 
                           '</span>';
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
                    return $value . ' <span class="text-green-500 font-bold"> Unidades</span>';
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