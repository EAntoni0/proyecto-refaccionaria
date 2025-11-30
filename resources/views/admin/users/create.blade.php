<x-admin-layout title="Nuevo Usuario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index')
    ],
    [
        'name' => 'Nuevo Usuario'
    ],
]">

    <x-wire-card>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <x-wire-input label="Nombre" name="name" placeholder="Nombre completo" 
                              value="{{ old('name') }}" />

                <x-wire-input type="email" label="Correo Electrónico" name="email" placeholder="correo@ejemplo.com" 
                              value="{{ old('email') }}" />

                <x-wire-input type="password" label="Contraseña" name="password" placeholder="Mínimo 8 caracteres" />

                <x-wire-native-select label="Rol de Usuario" name="role" placeholder="Seleccione un rol" 
                    :options="[
                        ['name' => 'Vendedor',  'id' => 'vendedor'],
                        ['name' => 'Almacenista', 'id' => 'almacenista'],
                        ['name' => 'Administrador', 'id' => 'admin'],
                    ]" 
                    option-label="name" option-value="id" 
                    wire:model.defer="role"
                    value="{{ old('role') }}" 
                />

            </div>

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>
                    Guardar Usuario
                </x-wire-button>
            </div>

        </form>
    </x-wire-card>

</x-admin-layout>