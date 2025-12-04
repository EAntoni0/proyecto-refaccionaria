<x-seller-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('seller.dashboard')
    ],

    [
        'name' => 'Historial de ventas',
    ],
]">



@livewire('seller.datatables.sales-table')
</x-seller-layout>