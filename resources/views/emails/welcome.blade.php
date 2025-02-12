<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Delta</title>
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
            background: #007bff;
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
        <h1>¡Bienvenido a Delta!</h1>
    </div>
    <div class="content">
        <p>Hola, <strong>{{$name}}</strong>,</p>
        <p>Gracias por registrarte en nuestra plataforma. Estamos encantados de tenerte con nosotros.</p>
        <p>Explora todas las funciones que hemos preparado para ti.</p>
        <a href="{{route('users.show', $name)}}" class="button">Ir a mi cuenta</a>
    </div>
    <div class="footer">
        <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        <p>&copy; 2025 - Nuestra Empresa. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
