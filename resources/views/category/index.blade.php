<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categorias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="{{route('category.create')}}" class="hover:text-green-500 transition-colors">Crear categoria</a>
    <br>
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('status') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif
    @foreach($categories as $category)
        <div class="bg-gray-500 transition-colors mt-6 w-64 h-24">
            <a href="{{route('category.show', $category)}}"><h2 class="font-bold hover:text-green-500">{{$category->name}}</h2></a>

            <a href="{{route('category.edit', $category)}}" class="hover:text-yellow-400">Editar</a>
            <form action="{{route('category.destroy', $category)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="mt-4 hover:text-red-600">Eliminar</button>
            </form>
        </div>
    @endforeach
    <br>
    <a href="{{route('index')}}" class="hover:text-blue-500 transition">Volver</a>
</body>
</html>
