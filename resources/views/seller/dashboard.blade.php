
<x-seller-layout :breadcrumbs="[
    

    [
        'name' => 'Punto de Venta', 
        'href' => route('seller.dashboard'),
    ],

    
]">


<div class="relative bg-gradient-to-r from-green-500 to-emerald-700 rounded-xl shadow-lg p-6 mb-8 overflow-hidden">
        <div class="relative z-10 text-white">
            <h1 class="text-3xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 opacity-90 text-lg">Da click sobre un producto para agregarlo al carrito</p>
            
            {{-- Como el POS está en el mismo dashboard, quizás un botón scroll o nada --}}
        </div>
        {{-- Icono decorativo --}}
        <i class="fa-solid fa-cash-register absolute -right-6 -bottom-8 text-9xl text-white opacity-20 transform rotate-12"></i>
        

    </div>

    <livewire:seller.point-of-sale />

</x-seller-layout>

