<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Mis productos")}}
        </h2>
    </x-slot>

    <div class="py-12">
        @include('components.delta-session')
    </div>

<div class="flex flex-col lg:flex-row justify-center space-y-6 lg:space-y-0 lg:space-x-10">
    <div class="bg-green-200 shadow-md rounded-lg overflow-hidden w-full lg:w-1/2 h-96 p-4">
        <h1 class="text-2xl font-semibold text-center mb-4 border-b-2 border-black">{{__('Publicados')}}</h1>
        <div class="overflow-y-scroll h-full">
            @foreach ($productsPublished as $product)
                <a href="{{route('product.show', $product)}}" class="">
                    <div class="p-4 border-b border-gray-200 hover:bg-gray-300 transition-colors rounded-lg">
                        <h2 class="text-lg font-medium">{{ $product->name }}</h2>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <p class="text-gray-800 font-semibold">{{ number_format($product->price / 100, 2, ',', '.') }} €</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="bg-yellow-200 shadow-md rounded-lg overflow-hidden w-full lg:w-1/2 h-96 p-4">
        <h1 class="text-2xl font-semibold text-center mb-4 border-b-2 border-black">{{__('No publicados')}}</h1>
        <div class="overflow-y-scroll h-full">
            @foreach ($productsPending as $product)
                <a href="{{route('product.show', $product)}}">
                    <div class="p-4 border-b border-gray-200 hover:bg-gray-300 transition-colors rounded-lg">
                        <h2 class="text-lg font-medium">{{ $product->name }}</h2>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <p class="text-gray-800 font-semibold">{{ number_format($product->price / 100, 2, ',', '.') }} €</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
