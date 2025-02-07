<!DOCTYPE html>
<html lang="es">

<x-delta-header />

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
<x-nav-delta />
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

<div class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
            <div class="col-span-4 sm:col-span-3">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex flex-col items-center">
                        <img src="{{ Str::startsWith($profile->avatar, 'http') ? $profile->avatar : asset('storage/' . $profile->avatar) }}" class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">

                        </img>
                        <h1 class="text-xl font-bold">{{$profile->name}}</h1>
                        <p class="text-gray-700">Delta User</p>
                        <div class="mt-6 flex flex-wrap gap-4 justify-center">
                            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Contact</a>
                        </div>
                    </div>
                    <hr class="my-6 border-t border-gray-300">
                    <div class="flex flex-col">
                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Información</span>
                        <ul class="space-y-2 text-gray-600">
                            <!-- Provincia (más importante) -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2M3 10h2m-2 5h2m4 0h12m-12-5h12m-12-5h12M9 5v14m6-14v14" />
                                </svg>
                                Provincia: <span class="ml-1 font-medium">{{ $profile->province ?? 'No disponible' }}</span>
                            </li>

                            <!-- Email (también importante) -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5a2.5 2.5 0 11-3-3 2.5 2.5 0 013 3zM5 20h14l-7-7-7 7z" />
                                </svg>
                                Email: <span class="ml-1 font-medium">{{ $profile->email }}</span>
                            </li>

                            <!-- Dirección -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10s4-4 9-4 9 4 9 4-4 4-9 4-9-4-9-4z" />
                                </svg>
                                Dirección: <span class="ml-1">{{ $profile->address ?? 'No disponible' }}</span>
                            </li>

                            <!-- Código Postal -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15h6m4 0h6m-10 0v6m0-6v-6m0 6h-4m4 0h4" />
                                </svg>
                                Código Postal: <span class="ml-1">{{ $profile->postal_code ?? 'No disponible' }}</span>
                            </li>

                            <!-- Teléfono -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10s4-4 9-4 9 4 9 4-4 4-9 4-9-4-9-4z" />
                                </svg>
                                Teléfono: <span class="ml-1">{{ $profile->phone_number ?? 'No disponible' }}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-span-4 sm:col-span-9">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-gray-100 p-4 rounded-lg hover:shadow-lg transition duration-300">
                                <a href="{{ route('product.show', $product) }}" class="block">
                                    <img class="w-full h-48 object-cover rounded-lg hover:scale-105 transition duration-300"
                                         src="{{ Str::startsWith($product->productImages->first()->img_path, 'http') ? $product->productImages->first()->img_path : asset('storage/' . $product->productImages->first()->img_path) }}"
                                         alt="{{ $product->name }}">

                                    <div class="pt-3 text-center">
                                        <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="pt-1 text-gray-700 font-medium">{{ $product->price }}€</p>
                                    </div>

                                    <div class="flex justify-center mt-2">
                                        <svg class="h-6 w-6 fill-current text-gray-500 hover:text-red-600 transition duration-300"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12,4.595c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412
                                    l7.332,7.332c0.17,0.299,0.498,0.492,0.875,0.492c0.322,0,0.609-0.163,0.792-0.409l7.415-7.415
                                    c2.354-2.354,2.354-6.049-0.002-8.416c-1.137-1.131-2.631-1.754-4.209-1.754C14.513,3.037,13.104,3.589,12,4.595z
                                    M18.791,6.205 c1.563,1.571,1.564,4.025,0.002,5.588L12,18.586l-6.793-6.793C3.645,10.23,3.646,7.776,5.205,6.209
                                    c0.76-0.756,1.754-1.172,2.799-1.172s2.035,0.416,2.789,1.17l0.5,0.5c0.391,0.391,1.023,0.391,1.414,0l0.5-0.5
                                    C14.719,4.698,17.281,4.702,18.791,6.205z"/>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-6 mt-8">

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Comentarios</h2>


                    <div class="mb-6">
                        <form action="{{route('comments.store', $profile->id)}}" method="POST">
                            @csrf
                            <textarea class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                      placeholder="Escribe un comentario..." name="comment"></textarea>
                            @error('comment')
                            <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                            @enderror
                            <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition duration-300" type="submit">
                                Publicar Comentario
                            </button>
                        </form>
                    </div>

                    @foreach($comments as $comment)
                        <!-- Lista de Comentarios -->
                        <div class="space-y-6">
                            <!-- Ejemplo de Comentario 1 -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm flex items-start space-x-4">
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-gray-300"
                                     src="{{ Str::startsWith($comment->buyer->avatar, 'http') ? $comment->buyer->avatar : asset('storage/' . $comment->buyer->avatar) }}" alt="{{$comment->buyer->name}}">
                                <div>
                                    <h3 class="text-gray-900 font-semibold">{{$comment->buyer->name}}</h3>
                                    <span class="text-gray-500 text-sm">Publicado el {{ $comment->created_at->format('d \d\e F, Y \a \l\a\s H:i') }}</span>
                                    <p class="mt-2 text-gray-700">
                                        {{$comment->comment}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<body />
