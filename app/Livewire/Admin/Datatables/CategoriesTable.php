<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Category; // Asegúrate de tener tu modelo Category
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Category::query()->orderBy('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),

            // Columna calculada para mostrar cuántos productos hay en esta categoría
            // (Opcional, pero muy útil para el admin)
            Column::make("Productos", "id")
                ->format(function($value, $row) {
                    return $row->products_count ?? '0'; 
                })
                ->label(fn($row) => $row->products()->count()),

            // COLUMNA DE ACCIONES (Editar y Borrar)
 
Column::make("Acciones")
    ->label(
        function($row) {
            // Pasamos la variable $category a la vista
            return view('admin.categories.actions', ['category' => $row]);
        }
    )
    ->html(),
        ];
    }
}