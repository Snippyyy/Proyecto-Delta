<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creacion Producto</title>
</head>
<body>
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Campos del producto -->
    <div>
        <x-input-label for="name" :value="__('Title')"/>
        <x-text-input name="name" required></x-text-input>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <textarea name="description" required></textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>

    <div>
        <x-input-label for="price" :value="__('Price')"/>
        <x-text-input name="price" required></x-text-input>
        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
    </div>

    <div>
        <x-input-label for="shipment" :value="__('Shipment')"/>
        <input type="hidden" name="shipment" value="0">
        <input type="checkbox" value="1" name="shipment"> <span>¿Aceptas envíos?</span>
        <x-input-error :messages="$errors->get('shipment')" class="mt-2"/>
    </div>

    <div>
        <x-input-label for="category_id" :value="__('Category')"/>
        <select name="category_id" id="category" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2"/>
    </div>

    <!-- Input Imagenes-->
    <div class="mb-4">
        <label for="img_path" class="block text-sm font-medium text-gray-700">
            {{ __('Images') }}
        </label>
        <div class="mt-2">
            <input
                type="file"
                name="img_path[]"
                multiple
                id="img_path"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500"
            >
        </div>
        <p class="mt-1 text-sm text-gray-500">You can upload multiple images.</p>
        <x-input-error :messages="$errors->get('img_path')" class="mt-2"/>
    </div>


    <x-primary-button>{{ __('Create Product') }}</x-primary-button>
</form>

<a href="{{}}"></a>
</body>
</html>
