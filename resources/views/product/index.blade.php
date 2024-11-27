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
    <h1>PRODCUTOS</h1>
    <a href=""></a>
    <div>
        @foreach($products as $product)
        <h2>{{$product->name}}</h2>
        @endforeach
    </div>
</body>
</html>
