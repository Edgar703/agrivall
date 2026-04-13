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
            background-color: #d4edda;
            color: #155724;
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

        .total-price {
            font-size: 1.3em;
            color: #2d5016;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏡 Solicitud de reserva recibida</h1>
            <p>Número de reserva: #{{ $reserva->id }}</p>
        </div>

        <div class="content">
            <p>Hola {{ $usuario->name }},</p>

            <p>Hemos recibido tu solicitud de reserva. Está pendiente de confirmación por parte del equipo de Agrivall. Te notificaremos por email cuando sea confirmada.</p>

            <div class="field">
                <div class="label">Período de la reserva</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
                </div>
            </div>

            <div class="field">
                <div class="label">Número de noches</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reserva->fecha_fin)->diffInDays(\Carbon\Carbon::parse($reserva->fecha_inicio)) }}
                </div>
            </div>

            <div class="field">
                <div class="label">Número de personas</div>
                <div class="value">{{ $reserva->num_personas }}</div>
            </div>

            @if ($reserva->comentario)
                <div class="field">
                    <div class="label">Comentarios adicionales</div>
                    <div class="value">{{ $reserva->comentario }}</div>
                </div>
            @endif

            <div class="price-section">
                <div class="label">Desglose de precio</div>
                <div class="field" style="margin-bottom: 5px; padding-bottom: 5px;">
                    <div class="value">
                        {{ $reserva->precio_por_noche }}€ por noche × {{ \Carbon\Carbon::parse($reserva->fecha_fin)->diffInDays(\Carbon\Carbon::parse($reserva->fecha_inicio)) }} noches × {{ number_format(1 + (($reserva->num_personas - 1) * 0.10), 2) }} (multiplicador por personas)
                    </div>
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    <span class="label">Precio total:</span>
                    <div class="total-price">{{ $reserva->precio_total }}€</div>
                </div>
            </div>

            <div class="field">
                <div class="label">Estado actual</div>
                <div>
                    <span class="status-badge" style="background-color:#fef3c7; color:#92400e;">
                        🕐 {{ $reserva->estado }}
                    </span>
                </div>
            </div>

            <p style="margin-top: 20px;">
                Una vez revisada tu solicitud, recibirás otro correo con la confirmación definitiva.
                Si tienes dudas, puedes contactarnos directamente.
            </p>

            <div class="footer">
                <p>Este es un correo automático. Por favor no respondas a este mensaje.</p>
                <p>&copy; {{ date('Y') }} Agrivall. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>

</html>
