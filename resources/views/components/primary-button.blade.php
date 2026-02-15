<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'btn-agrivall-primary',
]) }}>
    {{ $slot }}
</button>