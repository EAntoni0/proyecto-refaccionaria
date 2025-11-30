<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900 bg-cover bg-center"
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/fondo_1.avif') }}');">
    
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/70 backdrop-blur-md border border-white/50 shadow-2xl overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>