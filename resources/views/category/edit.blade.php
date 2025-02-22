<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Editar Categoria")}}
        </h2>
    </x-slot>
    <form action="{{route('category.update', $category)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div>
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
            </div>
            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
            <div>
                <input type="file" name="icon">
                <x-input-error :messages="$errors->get('icon')" class="mt-2"/>
            </div>
        </div>
        <br>
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </form>
</x-app-layout>

