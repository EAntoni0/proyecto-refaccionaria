
<x-seller-layout :breadcrumbs="[
    

    [
        'name' => 'Dashboard', 
        'href' => route('seller.dashboard'),
    ],

    
]">

<div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Nueva Venta</h1>
                <p class="text-gray-500">Selecciona productos para agregar al ticket.</p>
            </div>

            <livewire:seller.point-of-sale />

        </div>
    </div>




</x-seller-layout>

