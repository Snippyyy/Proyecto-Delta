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
<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
        @foreach($users as $user)
            <a href="{{route('users.show', $user)}}" class="block bg-white shadow-xl rounded-lg text-gray-900 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                <div class="rounded-t-lg h-32 overflow-hidden">
                    <img class="object-cover object-top w-full"
                         src="https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                         alt="Background">
                </div>
                <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
                    <img class="object-cover object-center h-32 w-32"
                         src="{{ $user->avatar ?? 'https://via.placeholder.com/150' }}"
                         alt="{{ $user->name }}">
                </div>
                <div class="text-center mt-2">
                    <h2 class="font-semibold text-lg">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->province ?? 'Ubicación no disponible' }}</p>
                    <p class="text-gray-500 text-sm">{{ $user->address ?? 'Dirección no disponible' }}</p>
                    <p class="text-gray-500 text-sm">Código Postal: {{ $user->postal_code ?? 'N/A' }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
<body />

