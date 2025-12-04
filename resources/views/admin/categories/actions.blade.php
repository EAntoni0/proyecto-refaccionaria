<div class="flex items-center space-x-2">
    
    {{-- 1. BOTÓN EDITAR --}}
    {{-- Ruta: admin.categories.edit | Variable: $category --}}
    <x-wire-button href="{{ route('admin.categories.edit', $category) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- 2. BOTÓN ELIMINAR --}}
    {{-- ID Único: delete-form-{id} para que JS sepa cuál borrar --}}
    <form id="delete-form-{{ $category->id }}" 
          action="{{ route('admin.categories.destroy', $category) }}" 
          method="POST">
        
        @csrf 
        @method('DELETE')
        
        {{-- 
             IMPORTANTE: 
             - type="button": Para que NO haga submit automático.
             - onclick: Llama a la función global que pusimos en scripts.blade.php 
        --}}
        <x-wire-button type="button" 
                       onclick="confirmDelete('delete-form-{{ $category->id }}')" 
                       red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>

</div>