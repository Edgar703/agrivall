<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'btn-agrivall-danger',
]) }}>
    {{ $slot }}
</button>