<nav id="store" class="w-full z-30 top-0 px-6 py-1">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
        <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl" href="{{ route('index') }}">
            {{ __('Productos') }}
        </a>
        @foreach($categories as $category)
            <a class="uppercase tracking-wide no-underline hover:underline font-bold text-gray-800 text-xs hover:under z-20" href="{{ route('category.show', $category) }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</nav>
