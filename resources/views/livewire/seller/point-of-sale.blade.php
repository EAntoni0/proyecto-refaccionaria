<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-2 space-y-4">
        
        <div class="bg-white p-4 rounded-lg shadow">
            <x-wire-input wire:model.live="search" placeholder="Buscar refacción (ej. Bujía)..." class="w-full" />
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($products as $product)
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer border border-gray-100"
                     wire:click="addToCart({{ $product->id }})">
                    
                    <div class="h-24 bg-gray-100 rounded mb-2 flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-car text-3xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                    <p class="text-lg font-bold text-blue-600 mt-1">${{ number_format($product->price, 2) }}</p>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-gray-500">
                    No se encontraron productos...
                </div>
            @endforelse
        </div>
    </div>

    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-4 sticky top-20">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-shopping-cart text-blue-600"></i> Ticket de Venta
            </h2>

            <div class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                @if(empty($cart))
                    <p class="text-center text-gray-400 py-4">El carrito está vacío</p>
                @else
                    @foreach($cart as $item)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-bold text-sm">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500">${{ $item['price'] }} x {{ $item['quantity'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                <button wire:click="removeFromCart({{ $item['id'] }})" class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between items-center text-xl font-bold mb-4">
                    <span>TOTAL:</span>
                    <span class="text-green-600">${{ number_format($total, 2) }}</span>
                </div>

                <x-wire-button wire:click="saveSale" w-full green lg :disabled="empty($cart)">
                    <i class="fa-solid fa-money-bill mr-2"></i> COBRAR
                </x-wire-button>
            </div>
        </div>
    </div>

</div>