@extends('layouts.delta')

@section('title', __("Carrito"))

@section('content')
   @if($carts->isEmpty())
       <h2 class="text-center">No tienes ningun carrito!</h2>
   @endif
    @foreach($carts as $cart)
        <div class="flex mt-3 items-center justify-center p-10">
            <div class="relative flex w-full max-w-[48rem] flex-row rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="relative m-0 w-2/5 shrink-0 overflow-hidden rounded-xl rounded-r-none bg-white bg-clip-border text-gray-700 flex items-center justify-center">
                    <img src="{{ Str::startsWith($cart->seller->avatar, 'http') ? $cart->seller->avatar : asset('storage/' . $cart->seller->avatar) }}" alt="Avatar" class="rounded-full w-60 h-60">
                </div>
                <a href="{{route('cart.show', $cart)}}" class="">
                    <div class="p-6 hover:bg-gray-300">
                        <h6 class="mb-4 block font-sans text-base font-semibold uppercase leading-relaxed tracking-normal text-pink-500 antialiased">
                            {{$cart->seller->name}}
                        </h6>
                        <h4 class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                            {{$cart->cart_items()->count()}} {{__("Articulos")}}
                        </h4>
                        <ul>
                            @foreach($cart->cart_items as $product)
                                <li class="mb-8 block text-base font-normal text-gray-700 antialiased w-max">
                                    {{$product->product->name}}
                                </li>
                            @endforeach
                        </ul>
                        @if(!$cart->discount_code)
                            <a class="inline-block" href="#">
                                <button
                                    class="flex select-none items-center gap-2 rounded-lg py-3 px-6 text-center align-middle font-sans font-bold uppercase text-pink-500 transition-all hover:bg-pink-500/10 active:bg-pink-500/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button"
                                >
                                    {{ number_format($cart->total_price / 100, 2, ',', '.') }}€
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                        class="h-4 w-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                                        ></path>
                                    </svg>
                                </button>
                            </a>
                        @else
                            <a class="inline-block" href="#">
                                <button
                                    class="flex select-none items-center gap-2 rounded-lg py-3 px-6 text-center align-middle font-sans font-bold uppercase text-gree-500 transition-all hover:bg-green-500/10 active:bg-green-500/30 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button"
                                >
                                    {{ number_format($cart->discount_price / 100, 2, ',', '.') }}€
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                        class="h-4 w-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                                        ></path>
                                    </svg>
                                </button>
                            </a>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@endsection


