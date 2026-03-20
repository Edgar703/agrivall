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
        'formato',
        'cantidad',
        'precio_unitario',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->precio_unitario * $this->cantidad;
    }
}
