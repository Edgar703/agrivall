<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .header {
            background-color: #7f1d1d;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }

        .content {
            background-color: white;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }

        .field {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            color: #7f1d1d;
            font-size: 0.9em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .value {
            color: #555;
            font-size: 0.95em;
        }

        .footer {
            text-align: center;
            font-size: 0.85em;
            color: #999;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8eeee;
            color: #7f1d1d;
            font-size: 0.85em;
            text-transform: uppercase;
        }

        .total-row td {
            font-weight: bold;
            color: #7f1d1d;
            border-top: 2px solid #7f1d1d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Pedido cancelado</h1>
            <p style="margin: 5px 0 0;">Pedido #{{ $pedido->id }}</p>
        </div>

        <div class="content">
            @if ($admin)
                <p>El usuario {{ $pedido->nombre_cliente }} ha cancelado su pedido.</p>
            @else
                <p>Hola {{ $pedido->nombre_cliente }},</p>
                <p>Tu pedido se ha cancelado correctamente.</p>
            @endif

            <div class="field">
                <div class="label">Email</div>
                <div class="value">{{ $pedido->email_cliente }}</div>
            </div>

            <div class="field">
                <div class="label">Productos</div>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Precio Ud.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lineas as $linea)
                            <tr>
                                <td>{{ $linea->producto?->nombre ?? 'Producto eliminado' }}</td>
                                <td>{{ $linea->cantidad }}</td>
                                <td>{{ number_format($linea->precio_unitario, 2) }} €</td>
                                <td>{{ number_format($linea->precio_unitario * $linea->cantidad, 2) }} €</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Total</td>
                            <td>{{ number_format($pedido->precio_pedido, 2) }} €</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <p>Este correo se ha generado automaticamente desde la web de Agrivall.</p>
            </div>
        </div>
    </div>
</body>

</html>