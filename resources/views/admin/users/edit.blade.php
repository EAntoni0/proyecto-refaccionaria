<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'), 
    ],
    [
        'name' => 'Editar Usuario',
    ],
]">

 <x-wire-card>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf 
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <x-wire-input label="Nombre" name="name" placeholder="Nombre completo" value="{{ old('name', $user->name) }}" />

                <x-wire-input type="email" label="Correo Electrónico" name="email" placeholder="correo@ejemplo.com" value="{{ old('email', $user->email) }}" />
                
                <x-wire-native-select label="Rol de Usuario" name="role" :options="[
                    ['name' => 'Vendedor',  'id' => 'vendedor'],
                    ['name' => 'Almacenista', 'id' => 'almacenista'],
                    ['name' => 'Administrador', 'id' => 'admin'],
                ]" option-label="name" option-value="id" wire:model.defer="role" value="{{ old('role', $user->role) }}" />

                <x-wire-input type="password" label="Nueva Contraseña" name="password" placeholder="Dejar en blanco para mantener la actual" />

            </div>

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue icon="check">
                    Actualizar Usuario
                </x-wire-button>
            </div>    
        </form>
    </x-wire-card>

</x-admin-layout>