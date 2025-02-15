<div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
    <a href="{{ route('product.show', $product) }}">
        <img class="hover:grow hover:shadow-lg" src="{{ Str::startsWith($product->productImages->first()->img_path, 'http') ? $product->productImages->first()->img_path : asset('storage/' . $product->productImages->first()->img_path) }}">
        <div class="pt-3 flex items-center justify-between">
            <p class="">{{ $product->name }}</p>
        </div>
        <p class="pt-1 text-gray-900">{{ number_format($product->price / 100, 2, ',', '.') }}€</p>
    </a>
    @auth
    <svg wire:click="toggleFavorite" class="h-6 w-6 fill-current text-gray-500 hover:text-black cursor-pointer transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        @if(auth()->user()->favoriteProducts->contains($product->id))
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        @else
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="none" stroke="currentColor" stroke-width="2"/>
        @endif
    </svg>
    @endauth
</div>
