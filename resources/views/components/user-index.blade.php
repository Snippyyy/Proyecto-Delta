<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
    @foreach($users as $user)
        <a href="{{route('users.show', $user)}}" class="block bg-neutral-200 shadow-xl rounded-lg text-gray-900 transform transition duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="rounded-t-lg h-32 overflow-hidden">
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
                <p class="text-gray-500 text-sm">{{__("Código Postal")}}: {{ $user->postal_code ?? 'N/A' }}</p>
            </div>
        </a>
    @endforeach
</div>
