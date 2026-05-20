<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'reservas';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'num_personas',
        'comentario',
        'estado',
        'precio_total',
        'precio_por_noche',
        'multiplicador_personas',
    ];

    // Convertir fechas a objetos date
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Relación: Una reserva pertenece a un usuario
     */
    public function usuario()
    {
        // Una reserva pertenece a un usuario
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    /**
     * Calcular el número de noches de la reserva
     */
    public function getNumNochesAttribute()
    {
        // Calcular días entre inicio y fin, mínimo 1
        return $this->fecha_inicio->diffInDays($this->fecha_fin) ?: 1;
    }

    /**
     * Calcular el multiplicador de precio según el número de personas
     * Fórmula: precio_por_noche * num_noches * (1 + (num_personas - 1) * 0.1)
     * Ej: 1 persona = 1.0x, 2 personas = 1.1x, 3 personas = 1.2x, etc.
     */
    public function calcularPrecioTotal()
    {
        // Obtener número de noches y precio base
        $numNoches = $this->num_noches;
        $precioBase = $this->precio_por_noche ?? 50;
        
        // Multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($this->num_personas - 1) * 0.10);
        
        return $precioBase * $numNoches * $multiplicador;
    }

    /**
     * Obtener el precio total formateado
     */
    public function getPrecioTotalAttribute()
    {
        // Usar precio guardado o calcularlo si no existe
        return $this->precio_total ?? $this->calcularPrecioTotal();
    }
}
