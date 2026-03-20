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
            background-color: #2d5016;
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

        .field:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #2d5016;
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

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            background-color: #fff3cd;
            color: #856404;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }

        .price-section {
            background-color: #f0f8f5;
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
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
            background-color: #f0f8f5;
            color: #2d5016;
            font-size: 0.85em;
            text-transform: uppercase;
        }

        .total-row td {
            font-weight: bold;
            font-size: 1.1em;
            color: #2d5016;
            border-top: 2px solid #2d5016;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🛒 Nuevo Pedido</h1>
            <p style="margin: 5px 0 0;">Pedido #{{ $pedido->id }}</p>
        </div>

        <div class="content">
            <div class="field">
                <div class="label">Cliente</div>
                <div class="value">{{ $pedido->nombre_cliente }}</div>
            </div>

            <div class="field">
                <div class="label">Email</div>
                <div class="value">{{ $pedido->email_cliente }}</div>
            </div>

            <div class="field">
                <div class="label">Teléfono</div>
                <div class="value">{{ $pedido->tlf_cliente }}</div>
            </div>

            <div class="field">
                <div class="label">Dirección de envío</div>
                <div class="value">{{ $pedido->direccion_envio }}</div>
            </div>

            <div class="field">
                <div class="label">Método de pago</div>
                <div class="value">{{ $pedido->metodo_pago }}</div>
            </div>

            <div class="field">
                <div class="label">Estado</div>
                <div class="status-badge">{{ $pedido->estado }}</div>
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

            <div class="field">
                <div class="label">Fecha del pedido</div>
                <div class="value">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</div>
            </div>

            <div class="footer">
                <p>Este correo se ha generado automáticamente desde la web de Agrivall.</p>
            </div>
        </div>
    </div>
</body>

</html>
