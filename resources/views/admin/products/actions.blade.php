<div class="flex items-center space-x-2">
    
    {{-- EDITAR --}}
    {{-- Aún no hemos creado la ruta edit, pero la dejamos lista --}}
    <x-wire-button href="{{ route('admin.products.edit', $product) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- ELIMINAR --}}
    <form id="delete-product-{{ $product->id }}" 
          action="{{ route('admin.products.destroy', $product) }}" 
          method="POST">
        
        @csrf 
        @method('DELETE')
        
        <x-wire-button type="button" 
                       onclick="confirmDelete('delete-product-{{ $product->id }}')" 
                       red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div>