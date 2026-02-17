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
            word-wrap: break-word;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 0.85em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo mensaje de contacto</h1>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Nombre</div>
                <div class="value">{{ $nombre }}</div>
            </div>

            <div class="field">
                <div class="label">Correo Electrónico</div>
                <div class="value">
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </div>
            </div>

            @if($telefono)
                <div class="field">
                    <div class="label">Teléfono</div>
                    <div class="value">{{ $telefono }}</div>
                </div>
            @endif

            <div class="field">
                <div class="label">Asunto</div>
                <div class="value">{{ $asunto }}</div>
            </div>

            <div class="field">
                <div class="label">Mensaje</div>
                <div class="value" style="white-space: pre-wrap;">{{ $mensaje }}</div>
            </div>
        </div>
        <div class="footer">
            <p>Este correo fue enviado desde el formulario de contacto de Agrivall</p>
        </div>
    </div>
</body>

</html>