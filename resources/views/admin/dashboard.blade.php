
<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard'),
    ],

    /*[
        'name' => 'Panel Admin', 
        'href' => route('admin.dashboard'),
    ],*/

    
]">



   {{-- 1. Banner de Bienvenida (Índigo Ejecutivo) --}}
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8 overflow-hidden">
        <div class="relative z-10 text-white">
            <h1 class="text-3xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <h1 class="text-3xl font-bold">Panel de Administración</h1>
        </div>
        <i class="fa-solid fa-chart-line absolute -right-4 -bottom-6 text-9xl text-white opacity-20"></i>
    </div>

    

</x-admin-layout>

