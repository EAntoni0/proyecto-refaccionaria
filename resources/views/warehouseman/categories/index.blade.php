<x-warehouseman-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('warehouseman.dashboard')
    ],

    [
        'name' => 'Categorías',
    ],
]">

<x-slot name="action">
    <x-wire-button blue href="{{ route('warehouseman.categories.create') }}">
        <i class="fa-solid fa-plus"></i>
        Nuevo
    </x-wire-button>
</x-slot>

@livewire('warehouseman.datatables.category-table')
</x-warehouseman-layout>