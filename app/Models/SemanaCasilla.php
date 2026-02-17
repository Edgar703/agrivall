<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemanaCasilla extends Model
{
    protected $table = 'semanascasilla';

    protected $fillable = [
        'anio',
        'numero_sem',
        'descriptor',
        'precio',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    /**
     * Relación: Una semana puede tener muchas reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'semana_casilla_id');
    }

    /**
     * Scope: Obtener solo semanas disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'libre');
    }

    /**
     * Scope: Obtener por año y número de semana
     */
    public function scopePorSemana($query, $anio, $numero_sem)
    {
        return $query->where('anio', $anio)->where('numero_sem', $numero_sem);
    }

    /**
     * Obtener descripción legible
     */
    public function getDescripcionLegibleAttribute()
    {
        return "{$this->descriptor} (${$this->precio})";
    }
}
