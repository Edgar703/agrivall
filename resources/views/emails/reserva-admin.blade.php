<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 8px; }
        .header { background-color: #2d5016; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .header h1 { margin: 0 0 8px; font-size: 1.4em; }
        .header p { margin: 0; font-size: 0.9em; opacity: 0.85; }
        .content { background-color: white; padding: 20px; border-radius: 0 0 8px 8px; }
        .field { margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid #eee; }
        .field:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #2d5016; font-size: 0.85em; text-transform: uppercase; margin-bottom: 4px; }
        .value { color: #555; font-size: 0.95em; }
        .alert-box { background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 6px; padding: 14px 16px; margin-bottom: 20px; }
        .alert-box strong { color: #856404; }
        .badge { display: inline-block; padding: 5px 10px; background-color: #fef3c7; color: #92400e; border-radius: 4px; font-weight: bold; font-size: 0.85em; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 20px; background-color: #2d5016; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9em; }
        .footer { text-align: center; font-size: 0.8em; color: #999; margin-top: 20px; padding-top: 16px; border-top: 1px solid #eee; }
        .price-box { background-color: #f0f8f5; padding: 14px; border-radius: 6px; margin-top: 10px; }
        .price-total { font-size: 1.3em; color: #2d5016; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏡 Nueva solicitud de reserva</h1>
            <p>Reserva #{{ $reserva->id }} — pendiente de confirmación</p>
        </div>

        <div class="content">
            <div class="alert-box">
                <strong>Acción requerida:</strong> Un cliente ha solicitado una reserva. Accede al panel de administración para confirmarla o rechazarla.
            </div>

            <div class="field">
                <div class="label">Cliente</div>
                <div class="value">
                    {{ $usuario->name }}<br>
                    <a href="mailto:{{ $usuario->email }}">{{ $usuario->email }}</a>
                </div>
            </div>

            <div class="field">
                <div class="label">Período solicitado</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}
                    —
                    {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
                    ({{ \Carbon\Carbon::parse($reserva->fecha_fin)->diffInDays(\Carbon\Carbon::parse($reserva->fecha_inicio)) }} noches)
                </div>
            </div>

            <div class="field">
                <div class="label">Número de personas</div>
                <div class="value">{{ $reserva->num_personas }}</div>
            </div>

            @if ($reserva->comentario)
                <div class="field">
                    <div class="label">Observaciones del cliente</div>
                    <div class="value">{{ $reserva->comentario }}</div>
                </div>
            @endif

            <div class="price-box">
                <div class="label">Precio estimado</div>
                <div class="price-total">{{ number_format($reserva->precio_total, 2) }} €</div>
                <div style="font-size:0.85em; color:#555; margin-top:4px;">
                    {{ $reserva->precio_por_noche }}€/noche ×
                    {{ \Carbon\Carbon::parse($reserva->fecha_fin)->diffInDays(\Carbon\Carbon::parse($reserva->fecha_inicio)) }} noches
                </div>
            </div>

            <div class="field" style="margin-top:16px;">
                <div class="label">Estado actual</div>
                <span class="badge">PRE-RESERVA</span>
            </div>

            <a href="{{ url('/admin/reservas') }}" class="btn">Ir al panel de reservas →</a>

            <div class="footer">
                <p>Este es un correo automático generado por Agrivall.</p>
                <p>&copy; {{ date('Y') }} Agrivall. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
