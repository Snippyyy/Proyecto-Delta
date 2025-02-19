<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Compra realizada</title>
</head>
<body>
<x-nav-delta/>
@if (session('status'))
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">¡Compra realizada con éxito!</h1>
    <p class="text-gray-700 mb-6">Gracias por tu compra. Tu pedido ha sido procesado correctamente.</p>
    <p class="text-gray-700 mb-6">Puedes revisar tu pedido en Area Personal -> Mis pedidos</p>
    <h3 class="text-black text-2xl p2 bg-green-200 rounded-md">¡Gracias por confiar en nosotros!</h3>
    <a href="{{ route('index') }}" class="text-blue-500 hover:underline">Volver a la página principal</a>
</div>
</body>
</html>
