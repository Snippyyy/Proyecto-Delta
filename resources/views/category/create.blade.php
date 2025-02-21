<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Crear categoria")}}
        </h2>
    </x-slot>
    <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data" class="ml-5 mt-5">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Titulo')"/>
            <x-text-input name="name"></x-text-input>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
            <br>
        <div>
            <x-input-label for="description" :value="__('Descripción')"/>
            <br>
            <textarea name="description"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
        </div>
        <br>
        <div>
            <input type="file" name="icon">
            <x-input-error :messages="$errors->get('icon')" class="mt-2"/>
        </div>
        <br>
        <x-primary-button>{{ __('Crear') }}</x-primary-button>
    </form>
</x-app-layout>
