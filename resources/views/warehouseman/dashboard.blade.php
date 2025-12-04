
<x-warehouseman-layout :breadcrumbs="[


    [
        'name' => 'Almacen', 
        'href' => route('warehouseman.dashboard'),
    ],

    
]">



<div class="relative bg-gradient-to-r from-cyan-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8 overflow-hidden">
        <div class="relative z-10 text-white">
            <h1 class="text-3xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 opacity-90 text-lg">Panel de control de Almacen</p>
            
        </div>
        {{-- Icono decorativo de fondo --}}
        <i class="fa-solid fa-warehouse absolute -right-6 -bottom-6 text-9xl text-white opacity-20 transform -rotate-12"></i>
    </div>

    




</x-warehouseman-layout>

