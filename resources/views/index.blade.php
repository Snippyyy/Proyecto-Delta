<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pagina principal</title>
</head>
<body>
    <ul>
        <li><a href="{{route('category.index')}}">Categorias</a></li>
        <li><a href="{{route('product.index')}}">Productos</a></li>
    </ul>
    <h2><a href="{{route('dashboard')}}">Volver</a></h2>
</body>
</html>