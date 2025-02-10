<div class="container mx-auto p-6">

    <div class="mb-4">
        <a href="{{ route('discount-code.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
            Crear Código
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($discountCodes as $code)
            <div class="relative p-4 rounded-lg shadow-lg {{ $code->is_active ? 'bg-white' : 'bg-gray-400' }} transition-colors">
                <h2 class="text-lg font-semibold mb-2">{{ $code->code }}</h2>
                <p class="text-sm text-gray-600">Descuento: <span class="font-bold">{{ $code->percentage }}%</span></p>
                <p class="text-sm text-gray-600">Inicio: {{ $code->created_at->format('Y-m-d') }}</p>
                <p class="text-sm text-gray-600">Fin: {{ $code->valid_until }}</p>

                <div class="mt-4 flex space-x-2">
                @if ($code->is_active)
                    <button wire:click="toggleStatus({{ $code->id }})"
                            class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded">
                        Desactivar
                    </button>
                @else
                    <button wire:click="toggleStatus({{ $code->id }})"
                            class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded">
                        Activar
                    </button>
                @endif
                    <button wire:click="deleteCode({{ $code->id }})"
                            class="px-4 py-2 text-white bg-red-700 hover:bg-red-800 rounded">
                        Eliminar
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
