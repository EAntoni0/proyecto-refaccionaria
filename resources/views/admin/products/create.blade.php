{{-- RECUERDA: Usamos x-layouts.admin para asegurar que carguen los scripts de alertas --}}
<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Productos',
        'href' => route('admin.products.index')
    ],
    [
        'name' => 'Nuevo',
    ],
]">

    <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6 max-w-4xl mx-auto mt-6">
        
        <div class="mb-6 border-b border-gray-200 pb-4">
            <h2 class="text-xl font-bold text-gray-900">Registrar Nuevo Producto</h2>
            <p class="text-sm text-gray-500 mt-1">Completa el formulario para añadir un nuevo ítem al inventario.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1. NOMBRE DEL PRODUCTO --}}
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Producto</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                       placeholder="Ej: Bujías de Iridio NGK" required>
                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                
                {{-- 2. CATEGORÍA --}}
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
                    <select id="category_id" 
                            name="category_id" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- 3. PRECIO (Input Group de Flowbite) --}}
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                            $
                        </span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               step="0.01" 
                               value="{{ old('price') }}"
                               class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" 
                               placeholder="0.00" required>
                    </div>
                    @error('price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- 4. DESCRIPCIÓN --}}
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                          placeholder="Escribe las características técnicas aquí...">{{ old('description') }}</textarea>
            </div>

            {{-- 5. IMAGEN (Dropzone estilo Flowbite) --}}
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Imagen del Producto</label>
                
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Haz clic para subir</span> o arrastra la imagen</p>
                            <p class="text-xs text-gray-500">PNG, JPG o GIF (MAX. 2MB)</p>
                            {{-- Texto dinámico para mostrar nombre del archivo --}}
                            <p id="file-name" class="mt-2 text-sm text-blue-600 font-semibold"></p>
                        </div>
                        <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>
                
                <script>
                    const fileInput = document.getElementById('dropzone-file');
                    const fileNameDisplay = document.getElementById('file-name');

                    fileInput.addEventListener('change', function(e) {
                        if(e.target.files[0]) {
                            fileNameDisplay.textContent = 'Archivo seleccionado: ' + e.target.files[0].name;
                        }
                    });
                </script>
                @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- BOTONES DE ACCIÓN --}}
            <div class="flex items-center justify-end space-x-2 border-t border-gray-200 pt-4">
                {{-- Botón Cancelar (Estilo Alternativo Flowbite) --}}
                <a href="{{ route('admin.products.index') }}" 
                   class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                    Cancelar
                </a>

                {{-- Botón Guardar (Estilo Principal Flowbite) --}}
                <button type="submit" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Producto
                </button>
            </div>

        </form>
    </div>

</x-admin-layout>