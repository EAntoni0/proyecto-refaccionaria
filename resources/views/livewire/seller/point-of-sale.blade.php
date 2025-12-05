<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-2 space-y-4">
        
        <div class="bg-white p-4 rounded-lg shadow">
            <x-wire-input wire:model.live="search" placeholder="Ingresa una palabra para buscar..." class="w-full" />
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($products as $product)
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer border border-gray-100"
                     wire:click="addToCart({{ $product->id }})">
                    
                 
                    <div class="h-32 w-full flex items-center justify-center bg-gray-50 rounded mb-2 overflow-hidden">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover">
                        @else
                            <i class="fa-solid fa-car text-3xl text-gray-300"></i>
                        @endif
                    </div>

                    <h3 class="font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                    
                    {{-- Control de Stock visual (Rojo si está agotado) --}}
                    @if($product->stock > 0)
                        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                    @else
                        <p class="text-sm text-red-500 font-bold">Agotado</p>
                    @endif

                    <p class="text-lg font-bold text-blue-600 mt-1">${{ number_format($product->price, 2) }}</p>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-gray-500">
                    <i class="fa-solid fa-search text-4xl mb-3 block opacity-20"></i>
                    No se encontraron productos...
                </div>
            @endforelse
        </div>
    </div>

    {{-- CARRO DE COMPRAS --}}
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-4 sticky top-20">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-shopping-cart text-blue-600"></i> Ticket
            </h2>

            <div class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                @if(empty($cart))
                    <div class="text-center text-gray-400 py-10">
                        <i class="fa-solid fa-basket-shopping text-4xl mb-2 opacity-50"></i>
                        <p>El carrito está vacío</p>
                    </div>
                @else
                    @foreach($cart as $item)
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <div>
                                <p class="font-bold text-sm text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500">${{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-sm text-gray-700">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                <button wire:click="removeFromCart({{ $item['id'] }})" 
                                        class="text-gray-400 hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center text-xl font-bold mb-4">
                    <span class="text-gray-700">TOTAL:</span>
                    <span class="text-green-600">${{ number_format($total, 2) }}</span>
                </div>

            
                <button wire:click="saveSale" 
                        @if(empty($cart)) disabled @endif
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <i class="fa-solid fa-money-bill-wave"></i> COBRAR
                </button>
            </div>
        </div>
    </div>

</div>