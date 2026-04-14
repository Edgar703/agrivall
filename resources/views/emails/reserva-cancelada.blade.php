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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Reserva cancelada</h1>
            <p style="margin: 5px 0 0;">Reserva #{{ $reserva->id }}</p>
        </div>

        <div class="content">
            @if ($admin)
                <p>El usuario {{ $usuario->name }} ha cancelado su reserva.</p>
            @else
                <p>Hola {{ $usuario->name }},</p>
                <p>Tu reserva se ha cancelado correctamente.</p>
            @endif

            <div class="field">
                <div class="label">Periodo</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
                </div>
            </div>

            <div class="field">
                <div class="label">Personas</div>
                <div class="value">{{ $reserva->num_personas }}</div>
            </div>

            <div class="field">
                <div class="label">Importe</div>
                <div class="value">{{ number_format($reserva->precio_total, 2) }} €</div>
            </div>

            <div class="footer">
                <p>Este correo se ha generado automaticamente desde la web de Agrivall.</p>
            </div>
        </div>
    </div>
</body>

</html>