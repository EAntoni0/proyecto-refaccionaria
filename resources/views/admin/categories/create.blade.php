<x-admin-layout :breadcrumbs="[
 [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],

    [
        'name' => 'Categorias',
    ],
    [
        'name' => 'Nueva Categoria',
    ],
]">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Categoría</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Categoría:</label>
                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Guardar
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-800">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>