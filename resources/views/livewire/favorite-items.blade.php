<li class="flex items-center mb-4 p-2 border rounded-lg relative @if($isDeleted) bg-gray-300 @endif">
    <a href="{{ route('product.show', $favorite->product->id) }}" class="flex items-center text-black no-underline hover:underline">
        <img src="{{ Str::startsWith($favorite->product->productImages->first()->img_path, 'http') ? $favorite->product->productImages->first()->img_path : asset('storage/' . $img['img_path'])}}" alt="{{ $favorite->product->title }}" class="w-12 h-12 mr-4">
        <span class="ml-4 font-bold text-lg">{{ $favorite->product->name }}</span>
    </a>
    @if(!$isDeleted)
        <button wire:click="toggleInput" class="ml-4 p-2 bg-blue-500 text-white rounded-lg">{{__("Añadir nota")}}</button>
        @if($showInput)
            <input type="text" wire:model.defer="note" class="ml-4 p-2 border rounded-lg focus:border-blue-500 focus:outline-none">
            <button wire:click="saveNote" class="ml-2 p-2 bg-green-500 text-white rounded-lg">{{__("Guardar")}}</button>
        @else
            <span class="ml-4">{{ $favorite->note }}</span>
        @endif
        <button wire:click="removeFavorite({{ $favorite->id }})" class="ml-4 p-2 bg-red-500 text-white rounded-lg float-right self-end absolute right-4">
            {{__("Eliminar")}}</button>
    @endif
</li>
