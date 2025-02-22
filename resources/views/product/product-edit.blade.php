@extends('layouts.delta')

@section('title', __("Editar Producto"))

@section('content')

    <div class="mt-5 bg-gray-200 rounded p-4">
        <form action="{{route('product.update', $product)}}" method="POST" enctype="multipart/form-data" class="ml-5 space-y-6">
            @csrf
            @method('PATCH')
            <div>
                <x-input-label for="name" :value="__('Titulo')" class="block text-sm font-medium text-gray-700"/>
                <x-text-input name="name" value="{{$product->name}}" class="mt-1 block w-full"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="description" :value="__('Descripción')" class="block text-sm font-medium text-gray-700"/>
                <textarea name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{$product->description}}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="price" :value="__('Precio')" class="block text-sm font-medium text-gray-700"/>
                <x-text-input name="price" value="{{ number_format($product->price / 100, 2, '.', '.') }}" class="mt-1 block w-full"/>€
                <x-input-error :messages="$errors->get('price')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="shipment" :value="__('Envio')" class="block text-sm font-medium text-gray-700"/>
                <input type="hidden" name="shipment" value="0">
                <input type="checkbox" value="1" name="shipment" @if($product->shipment) checked @endif class="mt-1">
                <span class="text-sm text-gray-700">¿Aceptas envios?</span>
                <x-input-error :messages="$errors->get('shipment')" class="mt-2"/>
            </div>
            <div class="mt-10">
                <x-input-label for="category_id" :value="__('Categoria')" class="block text-sm font-medium text-gray-700"/>
                <select name="category_id" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-10">
                <div class="mb-4">
                    <label class="flex items-center space-x-2 cursor-pointer w-44">
                        <input type="checkbox" id="toggle-delete" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring focus:ring-red-500" name="image_delete_confirmation" value="1">
                        <span class="text-sm font-medium text-gray-700">{{__("Eliminar imágenes")}}</span>
                    </label>
                </div>
                <div id="image-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($product->productImages as $image)
                        <div class="relative group">
                            <img src="{{Str::startsWith($image->img_path, 'http') ? $image->img_path : asset('storage/' . $image->img_path) }}" alt="Image {{ $product->name}}" class="w-32 h-32 rounded-lg border border-gray-300 shadow-sm m-12">
                            <input type="checkbox" name="images_to_delete[]" value="{{ $image->id }}" id="checkbox-{{ $image->id }}" class="absolute top-10 right-20 w-5 h-5 opacity-0 pointer-events-none transition-opacity duration-200">
                        </div>
                    @endforeach
                    <div class="flex flex-col items-center justify-center">
                        <label for="upload-image" class="flex flex-col items-center justify-center w-40 h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="mt-2 text-sm text-gray-500">Upload Image</span>
                            <input id="upload-image" type="file" name="img_path[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
            <x-primary-button class="mt-5">{{ __('Editar') }}</x-primary-button>
        </form>
    </div>
  <a href="{{route('product.show', $product)}}" class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-5 block text-center">Volver</a>

@endsection

@section('scripts')
    <script>
        const toggleDelete = document.getElementById('toggle-delete');
        const imageCheckboxes = document.querySelectorAll('#image-grid .relative input[type="checkbox"]');
        const imageLabels = document.querySelectorAll('#image-grid .relative label');

        toggleDelete.addEventListener('change', () => {
            const isChecked = toggleDelete.checked;

            imageCheckboxes.forEach(checkbox => {
                checkbox.style.opacity = isChecked ? '1' : '0';
                checkbox.style.pointerEvents = isChecked ? 'auto' : 'none';
            });

            imageLabels.forEach(label => {
                label.style.opacity = isChecked ? '1' : '0';
                label.style.pointerEvents = isChecked ? 'auto' : 'none';
            });
        });
    </script>
@endsection
