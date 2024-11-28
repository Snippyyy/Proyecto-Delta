<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$product->name}}</title>
</head>
<body>
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <h2 class="font-bold size-12">{{$product->name}}</h2>
        <h4>{{$product->description}}</h4>
        <p>Precio: {{$product->price}}</p>
        @if($product->shipment)
            <h3>Acepta envios</h3>
        @else
            <h3>No acepta envios</h3>
        @endif
    </div>
    <a href="{{route('product.edit', $product)}}" class="hover:text-yellow-400">Editar</a>
    <br>
    <br>
    <form action="{{route('product.delete', $product)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="mt-4 hover:text-red-600">Eliminar</button>
    </form>
    <br>
    <br>
    <h2><a href="{{route('product.index')}}">Volver</a></h2>
</body>
</html>
