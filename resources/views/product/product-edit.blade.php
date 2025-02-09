<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Producto - {{$product->name}}</title>
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
<div class="mt-5">
<form action="{{route('product.update', $product)}}" method="POST" enctype="multipart/form-data" class="ml-5">
    @csrf
    @method('PATCH')
    <div>
        <x-input-label for="name" :value="__('Title')"/>
        <x-text-input name="name" value="{{$product->name}}"></x-text-input>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <br>
        <textarea name="description">{{$product->description}}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="price" :value="__('Price')"/>
        <x-text-input name="price" value="{{$product->price}}"></x-text-input>€
        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="shipment" :value="__('Shipment')"/>
        <input type="hidden" name="shipment" value="0">
        <input type="checkbox"
               value="1"
               name="shipment"
               @if($product->shipment)
                   checked
               @endif
        > <span>¿Aceptas envios?</span>


        <x-input-error :messages="$errors->get('shipment')" class="mt-2"/>
    </div>
    <div class="mt-10">
        <x-input-label for="category_id" :value="__('Category')"/>
        <select name="category_id" id="category">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-10">
        <div class="mb-4">
            <!-- Botón/checkbox para habilitar la selección -->
            <label class="flex items-center space-x-2 cursor-pointer w-44">
                <input type="checkbox" id="toggle-delete" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring focus:ring-red-500" name="image_delete_confirmation" value="1">
                <span class="text-sm font-medium text-gray-700">Eliminar imágenes</span>
            </label>
        </div>
        <div id="image-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($product->productImages as $image)
                <div class="relative group">
                    <!-- Imagen -->
                    <img
                        src="{{Str::startsWith($image->img_path, 'http') ? $image->img_path : asset('storage/' . $image->img_path) }}"
                        alt="Image {{ $product->name}}"
                        class="w-32 h-32 rounded-lg border border-gray-300 shadow-sm m-12"
                    >

                    <!-- Checkbox (oculto inicialmente) -->
                    <input
                        type="checkbox"
                        name="images_to_delete[]"
                        value="{{ $image->id }}"
                        id="checkbox-{{ $image->id }}"
                        class="absolute top-10 right-20 w-5 h-5 opacity-0 pointer-events-none transition-opacity duration-200"
                    >
                </div>
            @endforeach
                <div class="flex flex-col items-center justify-center">
                    <!-- Contenedor del input -->
                    <label
                        for="upload-image"
                        class="flex flex-col items-center justify-center w-40 h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-200 transition-colors"
                    >
                        <!-- Ícono "+" -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <!-- Texto descriptivo -->
                        <span class="mt-2 text-sm text-gray-500">Upload Image</span>
                        <!-- Input oculto -->
                        <input
                            id="upload-image"
                            type="file"
                            name="img_path[]"
                            multiple
                            accept="image/*"
                        >
                    </label>
                </div>

        </div>
    </div>

    <br>

    <x-primary-button>{{ __('Edit') }}</x-primary-button>
</form>
</div>
<br>
<a href="{{route('product.show', $product)}}">Volver</a>
</body>


<script>
    // Selecciona el checkbox "Eliminar imágenes"
    const toggleDelete = document.getElementById('toggle-delete');
    // Selecciona únicamente los checkboxes relacionados con las imágenes
    const imageCheckboxes = document.querySelectorAll('#image-grid .relative input[type="checkbox"]');
    // Selecciona únicamente las etiquetas de los checkboxes relacionados con las imágenes
    const imageLabels = document.querySelectorAll('#image-grid .relative label');

    // Escucha el cambio del checkbox "Eliminar imágenes"
    toggleDelete.addEventListener('change', () => {
        const isChecked = toggleDelete.checked;

        // Muestra u oculta los checkboxes según el estado del botón
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
</html>
