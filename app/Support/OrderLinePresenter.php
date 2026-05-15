<?php

namespace App\Support;

class OrderLinePresenter
{
    public static function formatCantidad(float|string|null $cantidad, ?string $tipoVenta): string
    {
        $cantidad = (float) ($cantidad ?? 0);

        return $tipoVenta === 'peso'
            ? number_format($cantidad, 2, ',', '')
            : number_format($cantidad, 0, ',', '');
    }

    public static function productName(object $linea): string
    {
        $nombre = $linea->nombre_producto ?: ($linea->producto?->nombre ?? 'Producto eliminado');

        return $linea->nombre_variedad
            ? $nombre . ' — ' . $linea->nombre_variedad
            : $nombre;
    }

    public static function unitLabel(object $linea): string
    {
        return $linea->unidad_medida ?: 'ud';
    }

    public static function unitPriceLabel(object $linea): string
    {
        return number_format((float) $linea->precio_unitario, 2) . ' €/' . self::unitLabel($linea);
    }
}
