<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Categoria</title>
</head>
<body>
<form action="{{route('category.update', $category)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div>
        <div>
            <x-input-label for="name" :value="__('Title')"/>
            <x-text-input name="name"></x-text-input>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <br>
        <div>
            <x-input-label for="description" :value="__('Description')"/>
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
</body>
</html>
