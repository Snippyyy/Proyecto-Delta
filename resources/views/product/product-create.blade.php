@extends('layouts.delta')

@section('title', __("Creacion Producto"))

@section('content')

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="m-10 bg-white p-6 rounded-lg shadow-md">
        @csrf
        <!-- Campos del producto -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Titulo')" class="block text-sm font-medium text-gray-700"/>
            <x-text-input name="name" required class="mt-1 block w-full"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600"/>
        </div>

        <div class="mb-4">
            <x-input-label for="description" :value="__('Descripción')" class="block text-sm font-medium text-gray-700"/>
            <textarea name="description" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2 text-red-600"/>
        </div>

        <div class="mb-4">
            <x-input-label for="price" :value="__('Precio')" class="block text-sm font-medium text-gray-700"/>
            <x-text-input name="price" required class="mt-1 block w-full"/>€
            <x-input-error :messages="$errors->get('price')" class="mt-2 text-red-600"/>
        </div>

        <div class="mb-4">
            <x-input-label for="shipment" :value="__('Envio')" class="block text-sm font-medium text-gray-700"/>
            <input type="hidden" name="shipment" value="0">
            <input type="checkbox" value="1" name="shipment" class="mt-1"> <span>{{__("¿Aceptas envíos?")}}</span>
            <x-input-error :messages="$errors->get('shipment')" class="mt-2 text-red-600"/>
        </div>

        <div class="mb-4">
            <x-input-label for="category_id" :value="__('Categoria')" class="block text-sm font-medium text-gray-700"/>
            <select name="category_id" id="category" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-red-600"/>
        </div>

        <!-- Input Imagenes-->
        <div class="mb-4">
            <label for="img_path" class="block text-sm font-medium text-gray-700">
                {{ __('Imagenes') }}
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
            <p class="mt-1 text-sm text-gray-500">{{__("Puedes subir varias imagenes")}}</p>
            <x-input-error :messages="$errors->get('img_path')" class="mt-2 text-red-600"/>
        </div>

        <div class="mb-4">
            <label for="pending" class="block text-sm font-medium text-gray-700">{{__("¿Deseas guardar el producto en el borrador para publicarlo mas tarde?")}}</label>
            <input type="checkbox" name="pending" id="pending" value="1" class="mt-1">
        </div>

        <x-primary-button class="">{{ __('Crear Producto') }}</x-primary-button>
    </form>
@endsection
