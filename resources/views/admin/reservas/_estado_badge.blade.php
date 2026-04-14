@php
    $cfg = match ($estado) {
        'PRE-RESERVA' => ['color' => 'warning', 'label' => 'PRE-RESERVA', 'text' => 'dark'],
        'RESERVADO' => ['color' => 'success', 'label' => 'RESERVADO', 'text' => 'white'],
        'NO_DISPONIBLE' => ['color' => 'secondary', 'label' => 'NO DISPONIBLE', 'text' => 'white'],
        'CANCELADA' => ['color' => 'danger', 'label' => 'CANCELADA', 'text' => 'white'],
        default => ['color' => 'light', 'label' => strtoupper($estado ?? '—'), 'text' => 'dark'],
    };
@endphp
<span class="badge bg-{{ $cfg['color'] }} text-{{ $cfg['text'] }}">{{ $cfg['label'] }}</span>