<style>
    .btn-agrivall-danger {
        background-color: #dc3545;
        /* rojo peligro */
        border-color: #842029;
    }

    .btn-agrivall-danger:hover {
        background-color: #bb2d3b;
    }

    .btn-agrivall-danger:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.35);
    }
</style>
<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'btn-agrivall btn-agrivall-danger',
    ]) }}>
    {{ $slot }}
</button>
