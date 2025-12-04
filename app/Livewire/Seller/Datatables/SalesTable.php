<?php

namespace App\Livewire\Seller\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SalesTable extends DataTableComponent
{
    public function builder(): Builder
    {
        // 1. Cargamos la relación 'user' para poder mostrar el nombre del vendedor
        $query = Sale::query()->with('user'); 

        // 2. FILTRO INTELIGENTE:
        // Si el usuario conectado NO es admin, filtramos solo sus ventas.
        // Si ES admin, no aplicamos filtro (ve todas).
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // ID TICKET
            Column::make("Ticket #", "id")
                ->sortable()
                ->searchable(),

            // NUEVA COLUMNA: VENDEDOR
            // Accedemos a la relación user -> name
            Column::make("Vendedor", "user.name")
                ->sortable()
                ->searchable(),

            // FECHA
            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(function($value) {
                    return $value->format('d/m/Y h:i A'); 
                }),

            // TOTAL
            Column::make("Total", "total")
                ->sortable()
                ->format(function($value) {
                    return '$ ' . number_format($value, 2);
                }),

            // ESTADO
            Column::make("Estado", "status")
                ->sortable()
                ->format(function($value) {
                    if ($value === 'completed') {
                        return '<span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded">Completada</span>';
                    } 
                    if ($value === 'cancelled') {
                        return '<span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded">Cancelada</span>';
                    }
                    return $value;
                })
                ->html(),
        ];
    }
}