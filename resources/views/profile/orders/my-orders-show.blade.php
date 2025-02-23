<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __("Mis pedidos") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('components.delta-session')

            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h1 class="text-3xl font-bold mb-4">{{ __("Vendedor") }}:
                    <a href="{{ route('users.show', $order->seller_user->name) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                        {{ $order->seller_user->name }}
                    </a>
                </h1>
                <h2 class="text-2xl font-semibold mb-4">{{ __("Compra") }}:</h2>
                <ul class="list-disc list-inside mb-4">
                    @foreach($orderItems as $item)
                        <li class="text-xl">
                            <a href="{{ route('product.show', $item->product->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                                {{ $item->product->name }}
                            </a> - {{ number_format($item->product->price / 100, 2, ',', '.') }} €
                        </li>
                    @endforeach
                </ul>
                <h2 class="text-2xl font-semibold mb-4">{{ __("Precio total") }}: {{ number_format($order->total_price / 100, 2, ',', '.') }} €</h2>
                @if($order->status === "paid")
                    <h2 class="text-2xl font-semibold mb-4">{{__("Estado")}}: {{ __("Pagado") }}</h2>
                @elseif($order->status === "unpaid")
                    <h2 class="text-2xl font-semibold mb-4">{{__("Estado")}}: {{ __("Pendiente de pago") }}</h2>
                @elseif($order->status === "refunded")
                    <h2 class="text-2xl font-semibold mb-4">{{__("Estado")}}: {{ __("Reembolsado") }}</h2>
                @endif
                @if($order->shipment_number)
                    <h2 class="text-2xl font-semibold mb-4">{{ __("Numero de seguimiento") }}: {{ $order->shipment_number }}</h2>
                @else
                    <h2 class="text-2xl font-semibold mb-4">{{ __("Numero de seguimiento") }}: {{ __("No disponible") }}</h2>
                @endif
                <h2 class="text-2xl font-semibold mb-4">{{ __("Fecha de compra") }}: {{ $order->created_at->format('d/m/Y') }}</h2>
                <h1 class="text-3xl font-bold mb-4">{{ __("Comprador") }}:
                    <a href="{{ route('users.show', $order->buyer_user->name) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                        {{ $order->buyer_user->name }}
                    </a>
                </h1>
            </div>
            <div class="w-full flex justify-between">
                <a href="{{ route('my-orders') }}" class="text-blue-500 hover:text-blue-700 transition duration-300">{{ __("Volver") }}</a>
                <a href="{{ route('my-orders.download', $order) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">{{ __("Descargar Factura") }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
