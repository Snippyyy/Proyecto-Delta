<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Mis Vendidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h1 class="text-3xl font-bold mb-4">Vendedor:
                    <a href="" class="text-blue-500 hover:text-blue-700 transition duration-300">
                        {{$order->seller_user->name}}
                    </a>
                </h1>
                <h2 class="text-2xl font-semibold mb-4">Compra:</h2>
                <ul class="list-disc list-inside mb-4">
                    @foreach($orderItems as $item)
                        <li class="text-xl">
                            <a href="{{ route('product.show', $item->product->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                                {{$item->product->name}}
                            </a> - {{$item->product->price}} €
                        </li>
                    @endforeach
                </ul>
                <h2 class="text-2xl font-semibold mb-4">Precio total: {{$order->total_price}} €</h2>
                <h2 class="text-2xl font-semibold mb-4">Estado: {{ __($order->status) }}</h2>
                @if($order->shipment_number)
                    <h2 class="text-2xl font-semibold mb-4">Numero de seguimiento: {{$order->shipment_number}}</h2>
                    <form action="{{ route('shipment', $order) }}" method="POST">
                        @csrf
                        <input type="text" id="shipment_number" name="shipment_number">
                        @if ($errors->has('shipment_number'))
                            <div class="text-red-500 mt-2">
                                {{ $errors->first('shipment_number') }}
                            </div>
                        @endif
                        <button type="submit" class="ml-5 border border-black p-2 hover:bg-black hover:text-white focus:scale-50 active:scale-110">Editar</button>

                    </form>
                @else
                    <h2 class="text-2xl font-semibold mb-4">Introducir numero de seguimiento:</h2>
                    <form action="{{ route('shipment', $order) }}" method="POST">
                        @csrf
                        <input type="text" id="shipment_number" name="shipment_number">
                        @if ($errors->has('shipment_number'))
                            <div class="text-red-500 mt-2">
                                {{ $errors->first('shipment_number') }}
                            </div>
                        @endif
                        <button type="submit" class="ml-5 border border-black p-2 hover:bg-black hover:text-white focus:scale-50 active:scale-110">Establecer</button>
                    </form>
                @endif
                <h2 class="text-2xl font-semibold mb-4">Fecha de compra: {{$order->created_at->format('d/m/Y')}}</h2>
                <h1 class="text-3xl font-bold mb-4">Comprador:
                    <a href="" class="text-blue-500 hover:text-blue-700 transition duration-300">
                        {{$order->buyer_user->name}}
                    </a>
                </h1>
            </div>
                <a href="{{route('my-sold')}}" class="text-blue-500 hover:text-blue-700 transition duration-300">Volver</a>
        </div>
    </div>
</x-app-layout>
