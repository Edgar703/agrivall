<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoVariedad extends Model
{
    protected $table = 'producto_variedades';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'nombre',
        'precio',
        'activo',
        'orden',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
