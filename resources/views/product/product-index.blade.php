<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('status') }}
        </div>
    @endif
    <h1>PRODUCTOS</h1>
    <a href="{{route('product.create')}}" class="hover:text-blue-500">Crear un producto</a>


        @foreach($products as $product)
            <div class="mb-5 border-4 border-gray-700 w-20">
                <h2><a href="{{route('product.show', $product)}}">{{$product->name}}</a></h2>
                <a href=""></a>
            </div>
        @endforeach

    <h2><a href="{{route('index')}}">Volver</a></h2>
</body>
</html>
