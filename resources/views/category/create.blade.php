<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creacion categorias</title>
</head>
<body>
    <form action="{{route('category.store')}}" method="POST">
        @csrf
        <div>
        <x-text-input name="name"></x-text-input>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <br>
        <x-primary-button>{{ __('Create') }}</x-primary-button>
    </form>
</body>
</html>
