@props(["title" => config('app.name', 'Laravel'), "breadcrumbs" => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- 
             NOTA: Quitamos la línea de <script src="...sweetalert2..."></script> 
             porque ahora se carga dentro del @include del final.
        --}}

        <wireui:scripts />

        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50"">

        @include('layouts.navigation')
        
        {{-- Sidebar específico del Administrador --}}
        @include('layouts.includes.admin.sidebar') 

        <div class="p-4 sm:ml-64">
            
            {{-- Header con Breadcrumbs y Botones de Acción --}}
            <div class="mt-14 flex items-center justify-between w-full mb-4">
                 @include('layouts.breadcrumb', ['breadcrumbs' => $breadcrumbs ?? []])
                
                {{ $action ?? '' }}
            </div>

            {{-- Contenido Principal --}}
            {{ $slot }}

        </div>

        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script src="https://kit.fontawesome.com/b579ed6425.js" crossorigin="anonymous"></script>


        @include('layouts.partials.scripts')

    </body>
</html>