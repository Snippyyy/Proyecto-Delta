@extends('layouts.delta')

@section('title', __("Carrito"))

@section('content')

    <h1 class="text-center mt-10 font-bold text-3xl mb-10">{{__("CARRITO DE")}} {{$cart->seller->name}}</h1>
    <div class="overflow-x-auto p-10">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{__("Producto")}}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{__("Descripción")}}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{__("¿Envio?")}}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{__("Estado")}}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            {{__("Precio")}}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->cart_items as $product)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="w-full h-full rounded-full"
                                             src="{{ Str::startsWith($product->product->productImages()->first()->img_path, 'http') ? $product->product->productImages()->first()->img_path : asset('storage/' . $product->product->productImages()->first()->img_path) }}"
                                             alt="{{$product->product->name}}" />
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{route('product.show', $product->product)}}">
                                            <p class="text-gray-900 whitespace-no-wrap hover:bg-gray-300 rounded transition-colors p-2">
                                                {{$product->product->name}}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ \Illuminate\Support\Str::limit($product->product->description, 50)}}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($product->product->shipment)
                                    <span
                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>

                                            <span class="relative">Ok</span>
                                        @else
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                <span aria-hidden
                                                      class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                <span class="relative">No</span>
                                            </span>
                                        @endif
									</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($product->product->status == 'sold')
                                    <span
                                        class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        @else
                                            <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        @endif
                                            <span class="relative">{{$product->product->status}}</span>

									</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ number_format($product->product->price / 100, 2, ',', '.') }}€</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <form action="{{route('cart.destroy', [$cart, $product])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">{{__("Eliminar")}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right font-semibold">
                            @if($cart->discount_code)
                                <p class="text-red-600 font-bold mr-9">{{ number_format($cart->discount_price / 100, 2, ',', '.') }}€</p>
                            @else
                                <p class="text-gray-900 whitespace-no-wrap mr-12">{{ number_format($cart->total_price / 100, 2, ',', '.') }}€</p>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @if(auth()->check())
                @if($cart->discount_code)
                    <div class="text-center mt-5">
                        <p class="text-red-600">Descuento aplicado: {{$cart->discount_code->code}}</p>
                        <p class="text-red-600">Descuento: {{$cart->discount_code->percentage}}%</p>
                    </div>
                    <form action="{{route('cart.remove-discount', $cart)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class=" ml-3 mt-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Eliminar descuento</button>
                    </form>
                @else
                    <div>
                        <form action="{{route('cart.discountapply', $cart)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label for="discount">{{__("¿Codigo de descuento?")}}</label>
                            <input type="text" name="discount">
                            <button type="submit" class=" ml-3 mt-3 focus:outline-none text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-900">
                                {{__("Aplicar")}}</button>
                            @endif
                        </form>
                        <label for="buy"></label>
                        <br>
                        <form action="{{route("cart.checkout", $cart)}}" method="POST">
                            @csrf
                            <button type="submit" class=" ml-3 mt-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
                                {{__("Comprar")}}</button>
                        </form>
                    </div>
                    @else
                        <form action="{{route('login')}}" method="GET">
                            @csrf
                            <button type="submit" class=" ml-3 mt-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
                                {{__("Necesitas tener una cuenta para poder realizar la compra")}}</button>
                        </form>
                    @endif
        </div>
    </div>
@endsection
