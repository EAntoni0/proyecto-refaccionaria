<x-admin-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Categorias',
    ],
]">

<x-slot name="action">
    <x-wire-button blue href="{{ route('admin.categories.create') }}">
        <i class="fa-solid fa-plus"></i>
        Nuevo
    </x-wire-button>
</x-slot>

@livewire('admin.datatables.categories-table')
</x-admin-layout>

