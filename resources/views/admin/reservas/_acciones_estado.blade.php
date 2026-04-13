{{--
    Dropdown de acciones de estado para una reserva.
    Uso: @include('admin.reservas._acciones_estado', ['reserva' => $reserva])
--}}
<div class="dropdown">
    <button class="btn btn-agrivall-outline btn-sm dropdown-toggle" type="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        Cambiar estado
    </button>
    <ul class="dropdown-menu dropdown-menu-end">

        @if ($reserva->estado !== 'RESERVADO')
            <li>
                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="estado" value="RESERVADO">
                    <button type="submit" class="dropdown-item text-success fw-semibold">
                        ✅ Confirmar (RESERVADO)
                    </button>
                </form>
            </li>
        @endif

        @if ($reserva->estado !== 'PRE-RESERVA')
            <li>
                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="estado" value="PRE-RESERVA">
                    <button type="submit" class="dropdown-item">
                        🕐 Volver a PRE-RESERVA
                    </button>
                </form>
            </li>
        @endif

        @if ($reserva->estado !== 'NO_DISPONIBLE')
            <li>
                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="estado" value="NO_DISPONIBLE">
                    <button type="submit" class="dropdown-item text-secondary">
                        🚫 Marcar NO DISPONIBLE
                    </button>
                </form>
            </li>
        @endif

        <li><hr class="dropdown-divider"></li>

        @if ($reserva->estado !== 'cancelada')
            <li>
                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="estado" value="cancelada">
                    <button type="submit" class="dropdown-item text-danger"
                        onclick="return confirm('¿Cancelar esta reserva? Las fechas quedarán disponibles.')">
                        ✗ Cancelar reserva
                    </button>
                </form>
            </li>
        @endif

        <li>
            <a href="{{ route('reservas.show', $reserva->id) }}" class="dropdown-item">
                🔍 Ver detalle
            </a>
        </li>
    </ul>
</div>
