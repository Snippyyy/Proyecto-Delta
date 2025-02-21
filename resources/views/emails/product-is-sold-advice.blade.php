<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("Producto No Disponible")}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            color: #333;
        }
        .content {
            text-align: center;
            color: #555;
        }
        .button {
            display: inline-block;
            background: #dc3545;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{__("Producto No Disponible")}}</h1>
    </div>
    <div class="content">
        <p>{{__("Hola,")}} <strong>{{$username}}</strong>,</p>
        <p>{{__("Lamentamos informarte que el producto")}} <strong>{{$product->name}}</strong> {{__("del usuario")}} <strong>{{$product->user->name}}</strong>
            {{__("ya no está disponible puesto que otro usuario ha realizado la compra antes.")}}</p>
        <p>{{__("Si deseas ver más productos de")}} <strong>{{$product->user->name}}</strong>, {{__("te invitamos a explorar el catalogo.")}}</p>
        <a href="{{route('users.show', $product->user->name)}}" class="button">{{__("Ver Catálogo")}}</a>
    </div>
    <div class="footer">
        <p>{{__("Si tienes alguna pregunta, no dudes en contactarnos.")}}</p>
        <p>&copy; 2025 - Delta. {{__("Todos los derechos reservados.")}}</p>
    </div>
</div>
</body>
</html>
