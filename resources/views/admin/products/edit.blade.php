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
        'name' => 'Editar: ' . $product->name,
    ],
]">

    <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6 max-w-4xl mx-auto mt-6">
        
        <div class="mb-6 border-b border-gray-200 pb-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Editar Producto</h2>
                <p class="text-sm text-gray-500 mt-1">Modifica los detalles del producto.</p>
            </div>
            
            {{-- Botón para ver el estado actual --}}
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                Stock actual: {{ $product->stock }}
            </span>
        </div>

        {{-- 
             NOTA CLAVE: 
             1. La ruta apunta a 'update'.
             2. Pasamos el $product como parámetro.
             3. enctype es obligatorio para cambiar la foto.
        --}}
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- ¡Esto es vital para que Laravel sepa que es una actualización! --}}

            {{-- 1. NOMBRE --}}
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Producto</label>
                {{-- Usamos old('name', $product->name) para que muestre el valor guardado --}}
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $product->name) }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                       required>
                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                
                {{-- 2. CATEGORÍA --}}
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
                    <select id="category_id" 
                            name="category_id" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" disabled>Selecciona una opción</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{-- Lógica para pre-seleccionar la categoría actual --}}
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- 3. PRECIO --}}
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
                               value="{{ old('price', $product->price) }}"
                               class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" 
                               required>
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
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- 5. IMAGEN (Con Previsualización de la actual) --}}
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Imagen del Producto</label>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Columna 1: Imagen Actual (Si existe) --}}
                    <div class="md:col-span-1">
                        <p class="text-xs text-gray-500 mb-2">Imagen Actual:</p>
                        @if($product->image_path)
                            <div class="border rounded-lg p-1 bg-gray-50">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen actual" class="w-full h-auto rounded-md object-cover">
                            </div>
                        @else
                            <div class="border rounded-lg p-8 bg-gray-50 text-center text-gray-400">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <p class="text-xs">Sin imagen</p>
                            </div>
                        @endif
                    </div>

                    {{-- Columna 2 y 3: Dropzone para subir NUEVA imagen --}}
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-2">Cambiar Imagen (Opcional):</p>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clic para subir nueva</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG o GIF</p>
                                    <p id="file-name" class="mt-2 text-sm text-blue-600 font-semibold"></p>
                                </div>
                                <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>
                </div>
                
                <script>
                    const fileInput = document.getElementById('dropzone-file');
                    const fileNameDisplay = document.getElementById('file-name');
                    fileInput.addEventListener('change', function(e) {
                        if(e.target.files[0]) {
                            fileNameDisplay.textContent = 'Nueva selección: ' + e.target.files[0].name;
                        }
                    });
                </script>
                @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- BOTONES --}}
            <div class="flex items-center justify-end space-x-2 border-t border-gray-200 pt-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                    Cancelar
                </a>

                <button type="submit" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    <i class="fa-solid fa-sync mr-2"></i> Actualizar Producto
                </button>
            </div>

        </form>
    </div>

</x-admin-layout>