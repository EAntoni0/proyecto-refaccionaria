<x-warehouseman-layout :breadcrumbs="[
 [
        'name' => 'Almacen',
        'href' => route('warehouseman.dashboard')
    ],

    [
        'name' => 'Inventario',
    ],
]">

<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                {{-- AQUÍ LLAMAMOS A TU NUEVA TABLA RAPPASOFT --}}
                @livewire('warehouseman.datatables.inventory-table')
            </div>


</x-warehouseman-layout>

