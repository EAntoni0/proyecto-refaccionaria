<x-admin-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Ventas',
    ],
]">



@livewire('seller.datatables.sales-table')
</x-admin-layout>

