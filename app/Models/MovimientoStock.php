<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoStock extends Model
{
    protected $table = 'movimientos_stock';

    protected $fillable = [
        'producto_id',
        'producto_variedad_id',
        'user_id',
        'tipo',
        'cantidad',
        'stock_antes',
        'stock_despues',
        'descripcion',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'stock_antes' => 'decimal:2',
        'stock_despues' => 'decimal:2',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function variedad(): BelongsTo
    {
        return $this->belongsTo(ProductoVariedad::class, 'producto_variedad_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
