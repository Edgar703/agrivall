<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'user_id',
        'fecha_pedido',
        'nombre_cliente',
        'email_cliente',
        'tlf_cliente',
        'metodo_pago',
        'direccion_envio',
        'precio_pedido',
        'estado',
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function lineas(): HasMany
    {
        return $this->hasMany(LineaPedido::class, 'pedido_id');
    }
}
