<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'imagen',
        'precio',
        'tipo_venta',
        'unidad_medida',
        'step_cantidad',
        'descripcion',
        'categoria_id',
        'activo',
        'fecha_creacion',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'step_cantidad' => 'decimal:2',
        'activo' => 'boolean',
        'fecha_creacion' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function variedades(): HasMany
    {
        return $this->hasMany(ProductoVariedad::class, 'producto_id')->orderBy('orden')->orderBy('id');
    }

    public function variedadesActivas(): HasMany
    {
        return $this->variedades()->where('activo', true);
    }

    public function tieneVariedades(): bool
    {
        return $this->relationLoaded('variedades')
            ? $this->variedades->isNotEmpty()
            : $this->variedades()->exists();
    }

    public function vendePorPeso(): bool
    {
        return $this->tipo_venta === 'peso';
    }

    public function getUnidadEtiquetaAttribute(): string
    {
        return $this->unidad_medida === 'kg' ? 'kg' : 'ud';
    }
}
