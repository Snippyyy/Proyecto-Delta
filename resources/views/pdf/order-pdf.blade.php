<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("Factura") }}</title>
    <style>
        body {
            padding: 10px;
            background-color: #f7fafc;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 32rem;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2rem;
            border: 1px solid #d2d6dc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #d2d6dc;
            padding-bottom: 1rem;
        }
        .header-content {
            flex: 1;
        }
        .logo {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            padding: 18px;
        }
        .logo img {
            width: 100px;
            height: auto;
            display: block;
        }
        .header h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a5568;
            margin: 0;
        }
        .header p {
            font-size: 0.875rem;
            color: #a0aec0;
            margin: 2px 0;
        }
        .client-info {
            margin-top: 1rem;
        }
        .client-info h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4a5568;
        }
        .client-info p {
            font-size: 0.875rem;
            color: #718096;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d2d6dc;
            margin-top: 1.5rem;
        }
        .table th, .table td {
            border: 1px solid #d2d6dc;
            padding: 0.5rem;
        }
        .table th {
            background-color: #edf2f7;
            color: #4a5568;
            text-align: left;
        }
        .table td {
            text-align: right;
        }
        .table td:first-child {
            text-align: left;
        }
        .total {
            margin-top: 1.5rem;
            text-align: right;
        }
        .total p {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4a5568;
        }
        .total p:last-child {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2d3748;
        }
        .note {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #718096;
            border-top: 1px solid #d2d6dc;
            padding-top: 1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <img src="{{ public_path('logo.png') }}" alt="DELTA">
            </div>
            <p>{{ __("Número") }}: #{{ $order->id }}</p>
            <p>{{ __("Fecha") }}: {{ $order->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="client-info">
        <h3>{{ __("Datos del Cliente") }}</h3>
        <p>{{ $order->buyer_user->name }}</p>
        <p>{{ $order->buyer_user->email }}</p>
        <p>{{ $order->buyer_user->address }}</p>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>{{ __("Descripción") }}</th>
                <th>{{ __("Precio") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->product->price / 100, 2, ',', '.') }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        <p>Total: {{ number_format($order->total_price / 100, 2, ',', '.') }} €</p>
    </div>

    <div class="note">
        <p>{{ __("Gracias por su compra. Si tiene preguntas sobre esta factura, contáctenos.") }}</p>
    </div>
</div>
</body>
</html>
