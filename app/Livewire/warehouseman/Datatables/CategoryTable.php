<?php

namespace App\Livewire\warehouseman\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;


class CategoryTable extends DataTableComponent
{
    //protected $model = Category::class;
    public function builder():Builder
    {
        return Category::query();
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
            Column::make("Acciones")
                ->label(
                    function($row){
                        return view('warehouseman.categories.actions', ['category' => $row]);
                    }
            ),
        ];
    }
}
