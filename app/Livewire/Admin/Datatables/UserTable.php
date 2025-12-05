<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

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
                ->sortable()
                ->searchable(),
                
            Column::make("Correo Electrónico", "email")
                ->sortable()
                ->searchable(),


            Column::make("Rol", "role")
    ->sortable()
    ->format(function($value) {

        $rol = strtolower($value);

        // poner un color al texto según el rol
        $color = match($rol) {
            'admin' => 'text-red-600',       
            'almacenista' => 'text-blue-600', 
            'vendedor' => 'text-green-600',  
            default => 'text-gray-600',      
        };

        return '<span class="'.$color.' font-bold">' . ucfirst($value) . '</span>';
    })
    ->html(),
            Column::make("Acciones")
    ->label(
        fn($row) => view('admin.users.actions', ['user' => $row])->render() 
    )
    ->html(),
        ];
    }
}