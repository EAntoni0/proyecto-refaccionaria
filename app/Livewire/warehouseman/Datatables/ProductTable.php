<?php

namespace App\Livewire\warehouseman\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class ProductTable extends DataTableComponent
{
    //protected $model = User::class;
    public function builder():Builder
    {
        return User::query()->with('roles');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable(),
            Column::make("Correo Electrónico", "email")
                ->sortable(),
            /*Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),*/
            Column::make("Número de id", "id_number")
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->sortable(),
            Column::make("Rol", "roles")
                ->label(function($row) {
                    return $row->roles->first()?->name ?? 'Sin Rol';
                }),
            Column::make("Acciones")
                ->label(
                    function($row){
                        return view('admin.users.actions', ['user' => $row]);
                    }
            ),
        ];
    }
}
