<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineaPedido extends Model
{
    protected $table = 'linea_pedido';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'producto_variedad_id',
        'nombre_producto',
        'nombre_variedad',
        'tipo_venta',
        'unidad_medida',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function variedad(): BelongsTo
    {
        return $this->belongsTo(ProductoVariedad::class, 'producto_variedad_id');
    }

    public function getDescripcionCompletaAttribute(): string
    {
        return $this->nombre_variedad
            ? $this->nombre_producto . ' — ' . $this->nombre_variedad
            : $this->nombre_producto;
    }
}
