<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Mis Vendidos")}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @include('components.delta-session')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders as $order)
                    <a href="{{route('my-sold.show', $order)}}" class="block transform transition-transform duration-300 hover:scale-105">
                        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg hover:bg-green-400 transition-shadow duration-300">
                            <h3 class="text-lg font-semibold mb-2">{{__("Pedido")}} #{{ $order->id }}</h3>
                            <p class="text-gray-600 mb-2">{{__("Estado")}}: {{ __($order->status) }}</p>
                            <p class="text-gray-600 mb-2">{{__("Precio total")}}: {{ number_format($order->total_price / 100, 2, ',', '.') }} €</p>
                            <p class="text-gray-600 mb-2">{{__("Fecha de compra")}}: {{ $order->created_at->format('d/m/Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
