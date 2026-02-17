<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'imagen',
        'precio',
        'descripcion',
        'categoria_id',
        'activo',
        'fecha_creacion',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_creacion' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
