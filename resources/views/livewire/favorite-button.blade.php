<div>
    <button
        class="group transition-all duration-500 p-4 rounded-full bg-indigo-50 hover:bg-indigo-100 hover:shadow-sm hover:shadow-indigo-300" wire:click="toggleFavorite">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none">
            @if(auth()->user()->favoriteProducts->contains($product->id))
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#4F46E5"/>
            @else
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="none" stroke="#4F46E5" stroke-width="1.6"/>
            @endif
        </svg>
    </button>
    <div class="mt-4">
        @if($product->favoritedByUsers()->count() == 0)
            <p class="text-gray-500 italic">Nadie ha guardado este producto en favoritos</p>
        @else
            <p class="text-gray-700">Guardado en favoritos por: <span class="font-semibold">{{$product->favoritedByUsers()->count()}}</span> Usuarios</p>
        @endif
    </div>
</div>
