<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'pedidos';

    // Campos que se pueden rellenar masivamente
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

    // Convertir fecha_pedido a objeto fecha
    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        // Un pedido pertenece a un usuario
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function lineas(): HasMany
    {
        // Un pedido tiene muchas líneas
        return $this->hasMany(LineaPedido::class, 'pedido_id');
    }
}
