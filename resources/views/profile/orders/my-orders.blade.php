<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis pedidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders as $order)
                    <a href="{{route('my-orders.show', $order)}}" class="block transform transition-transform duration-300 hover:scale-105">
                        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg hover:bg-fuchsia-400 transition-shadow duration-300">
                            <h3 class="text-lg font-semibold mb-2">Pedido #{{ $order->id }}</h3>
                            <p class="text-gray-600 mb-2">Estado: {{ __($order->status) }}</p>
                            <p class="text-gray-600 mb-2">Precio total: {{ $order->total_price }} €</p>
                            <p class="text-gray-600 mb-2">Fecha de compra: {{ $order->created_at->format('d/m/Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
