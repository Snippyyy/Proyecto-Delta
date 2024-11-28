<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$category->name}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <h2 class="font-bold size-12">{{$category->name}}</h2>
    @if($category->icon)
        <img src="{{Str::startsWith($category->icon, 'http') ? $category->icon : asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" class="w-40 h-40">
    @endif
    <h4>{{$category->description}}</h4>
    <a href="{{route('category.edit', $category)}}" class="hover:text-yellow-400">Editar</a>
    <br>
    <br>
    @foreach($products as $product)
        <div class="mb-5 border-4 border-gray-700 w-20">
            <h2><a href="{{route('product.show', $product)}}">{{$product->name}}</a></h2>
        </div>
    @endforeach

    <form action="{{route('category.destroy', $category)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="mt-4 hover:text-red-600">Eliminar categoria</button>
    </form>

    <br>
    <br>
    <a href="{{route('category.index')}}">Volver</a>
</body>
</html>
