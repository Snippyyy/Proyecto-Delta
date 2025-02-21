<!DOCTYPE html>
<html>
<head>
    <title>{{__("Compra Exitosa")}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            color: #4CAF50;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
<h1>{{__("¡Gracias por tu compra!")}}</h1>
<p>{{__("Estimado/a")}} {{ $order->buyer_user->name }},</p>
<p>{{__("Nos complace informarte que tu compra ha sido exitosa. Aquí están los detalles de tu pedido")}}:</p>
<ul>
    <li><strong>{{__("ID del Pedido")}}:</strong> {{ $order->id }}</li>
    <li><strong>{{__("Fecha del Pedido")}}:</strong> {{ $order->created_at->format('d F, Y') }}</li>
    <li><strong>{{__("Total")}}:</strong> {{ number_format($order->total_price / 100, 2, ',', '.') }}€</li>
</ul>
<h2>{{__("Detalles de los productos comprados")}}:</h2>
<ul>
    @foreach ($order->orderItems as $orderItem)
        <li>
            <strong>{{__("Producto")}}:</strong> {{ $orderItem->product->name }}<br>
            <strong>{{__("Precio")}}:</strong> {{ number_format($orderItem->product->price / 100, 2, ',', '.') }} €
        </li>
    @endforeach
    </ul>
<div class="footer">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{__("Todos los derechos reservados.")}}</p>
</div>
</body>
</html>
