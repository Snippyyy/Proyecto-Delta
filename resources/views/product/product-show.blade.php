<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$product->name}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<x-nav-delta/>
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
{{--<div>--}}
{{--    <h2 class="font-bold size-12">{{$product->name}}</h2>--}}
{{--    <h4>{{$product->description}}</h4>--}}
{{--    <p>Precio: {{$product->price}}</p>--}}
{{--    @if($product->shipment)--}}
{{--        <h3>Acepta envios</h3>--}}
{{--    @else--}}
{{--        <h3>No acepta envios</h3>--}}
{{--    @endif--}}
{{--    @foreach($product->productImages as $img)--}}
{{--        <img src="{{asset('storage/' . $img['img_path'])}}" alt="imagenprueba">--}}
{{--        <img src="{{Str::startsWith($img->img_path, 'http') ? $img->img_path : asset('storage/' . $img['img_path'])}}" alt="imagenprueba">--}}
{{--    @endforeach--}}
{{--</div>--}}
{{--<a href="{{route('product.edit', $product)}}" class="hover:text-yellow-400">Editar</a>--}}
{{--<br>--}}
{{--<br>--}}
{{--<form action="{{route('product.delete', $product)}}" method="POST">--}}
{{--    @csrf--}}
{{--    @method('DELETE')--}}
{{--    <button type="submit" class="mt-4 hover:text-red-600">Eliminar</button>--}}
{{--</form>--}}
{{--<br>--}}
{{--<br>--}}
{{--<h2><a href="{{route('product.index')}}">Volver</a></h2>--}}



<section class="py-10 lg:py-24 relative ">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
            <div class="pro-detail w-full flex flex-col justify-center order-last lg:order-none max-lg:max-w-[608px] max-lg:mx-auto">
                <p class="font-medium text-lg text-indigo-600 mb-4">{{$product->category->name}}</p>
                <h2 class="mb-2 font-manrope font-bold text-3xl leading-10 text-gray-900">{{$product->name}}
                </h2>
                <div class="flex flex-col sm:flex-row sm:items-center mb-6">
                    <h6
                        class="font-manrope font-semibold text-2xl leading-9 text-gray-900 pr-5 sm:border-r border-gray-200 mr-5">
                        {{$product->price}}€
                    </h6>
                    <h6> {{$product->user->name}}</h6>
                </div>
                <p class="text-gray-500 text-base font-normal mb-8 ">
                    {{$product->description}}
                </p>
                <div class="block w-full">
                    @if($product->shipment)
                        <p class="font-medium text-lg leading-8 text-green-700 mb-4">Acepta envios</p>
                    @else
                        <p class="font-medium text-lg leading-8 text-gray-900 mb-4">No acepta envios</p>
                    @endif
                    <div class="text">
                        <div class="block w-full mb-6">
                            <p class="font-medium text-lg leading-8 text-gray-900 mb-4">{{$product->status}}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
                            <button
                                class="group py-4 px-5 rounded-full bg-indigo-50 text-indigo-600 font-semibold text-lg w-full flex items-center justify-center gap-2 shadow-sm shadow-transparent transition-all duration-500 hover:bg-indigo-100 hover:shadow-indigo-200">
                                <svg class="stroke-indigo-600 transition-all duration-500" width="22" height="22"
                                     viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908C5.73339 14.0221 5.86724 14.7377 6.37649 15.1605C6.88573 15.5833 7.61377 15.5833 9.06984 15.5833H15.2379C16.6941 15.5833 17.4222 15.5833 17.9314 15.1605C18.4407 14.7376 18.5745 14.0219 18.8421 12.5906L19.3564 9.84059C19.7324 7.82973 19.9203 6.8243 19.3705 6.16215C18.8207 5.5 17.7979 5.5 15.7522 5.5H4.1394ZM4.1394 5.5L3.66797 2.75"
                                        stroke="" stroke-width="1.6" stroke-linecap="round" />
                                </svg>
                                Añadir al carrito</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                class="group transition-all duration-500 p-4 rounded-full bg-indigo-50 hover:bg-indigo-100 hover:shadow-sm hover:shadow-indigo-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"
                                     fill="none">
                                    <path
                                        d="M4.47084 14.3196L13.0281 22.7501L21.9599 13.9506M13.0034 5.07888C15.4786 2.64037 19.5008 2.64037 21.976 5.07888C24.4511 7.5254 24.4511 11.4799 21.9841 13.9265M12.9956 5.07888C10.5204 2.64037 6.49824 2.64037 4.02307 5.07888C1.54789 7.51738 1.54789 11.4799 4.02307 13.9184M4.02307 13.9184L4.04407 13.939M4.02307 13.9184L4.46274 14.3115"
                                        stroke="#4F46E5" stroke-width="1.6" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </button>
                            <button
                                class="text-center w-full px-5 py-4 rounded-[100px] bg-indigo-600 flex items-center justify-center font-semibold text-lg text-white shadow-sm transition-all duration-500 hover:bg-indigo-700 hover:shadow-indigo-400">
                                ¡Comprar YA!
                            </button>
                        </div>
                        @if(auth()->id() == $product->seller_id)
                        <div class="flex">
                            <a href="{{ route('product.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 active:bg-yellow-600 disabled:opacity-25 transition mt-12 mr-5">
                                Editar
                            </a>
                            <form action="{{route('product.delete', $product)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition mt-12">Eliminar</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($product->productImages as $img)
                        <div class="swiper-slide">
                            <img src="{{Str::startsWith($img->img_path, 'http') ? $img->img_path : asset('storage/' . $img['img_path'])}}"
                                 alt="{{$product->name}}"
                                 class="h-96 w-96 ml-28">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
