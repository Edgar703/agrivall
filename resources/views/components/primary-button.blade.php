<style>
    .btn-agrivall {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 10px 18px;
        border-radius: 10px;

        background-color: #198754;
        /* verde Agrivall */
        border: 2px solid #6b3f16;
        /* marrón/dorado */

        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;

        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .btn-agrivall:hover {
        background-color: #157347;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .btn-agrivall:active {
        transform: translateY(1px);
    }

    .btn-agrivall:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.35);
    }

    .btn-agrivall:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }
</style>

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'btn-agrivall',
]) }}>
    {{ $slot }}
</button>
