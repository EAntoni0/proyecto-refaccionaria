<x-admin-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Productos',
    ],
]">

<x-slot name="action">
    <x-wire-button blue href="{{ route('admin.products.create') }}">
        <i class="fa-solid fa-plus"></i>
        Nuevo Producto
    </x-wire-button>
</x-slot>

@livewire('admin.datatables.products-table')
</x-admin-layout>

