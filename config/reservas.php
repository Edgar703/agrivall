<?php

return [
    /**
     * Precio base por noche de la reserva
     * Este valor se multiplica por el número de noches y por un factor basado en el número de personas
     */
    'precio_por_noche' => env('RESERVA_PRECIO_POR_NOCHE', 50),

    /**
     * Porcentaje de aumento por cada persona adicional
     * Ejemplo: 0.10 = 10% de aumento por cada persona adicional
     * 1 persona = 1.0x, 2 personas = 1.1x, 3 personas = 1.2x, etc.
     */
    'incremento_por_persona' => 0.10,
];
