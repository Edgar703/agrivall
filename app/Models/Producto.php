<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'productos';

    // Esta tabla no usa created_at ni updated_at
    public $timestamps = false;

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'nombre',
        'imagen',
        'precio',
        'tipo_venta',
        'unidad_medida',
        'step_cantidad',
        'stock_actual',
        'stock_minimo',
        'controla_stock',
        'descripcion',
        'categoria_id',
        'activo',
        'fecha_creacion',
    ];

    // Convertir campos a tipos correctos
    protected $casts = [
        'precio' => 'decimal:2',
        'step_cantidad' => 'decimal:2',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'controla_stock' => 'boolean',
        'activo' => 'boolean',
        'fecha_creacion' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        // Un producto pertenece a una categoría
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function variedades(): HasMany
    {
        return $this->hasMany(ProductoVariedad::class, 'producto_id')->orderBy('orden')->orderBy('id');
    }

    public function movimientosStock(): HasMany
    {
        return $this->hasMany(MovimientoStock::class, 'producto_id')->latest();
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

    public function controlaStock(): bool
    {
        return (bool) $this->controla_stock;
    }

    public function tieneStock(float $cantidad): bool
    {
        return !$this->controlaStock() || (float) $this->stock_actual >= $cantidad;
    }

    public function estaAgotado(): bool
    {
        return $this->controlaStock() && (float) $this->stock_actual <= 0;
    }

    public function tieneStockBajo(): bool
    {
        return $this->controlaStock()
            && (float) $this->stock_actual > 0
            && (float) $this->stock_actual <= (float) $this->stock_minimo;
    }

    public function etiquetaStock(): string
    {
        if (!$this->controlaStock()) {
            return 'Disponible';
        }

        return rtrim(rtrim(number_format((float) $this->stock_actual, 2, ',', '.'), '0'), ',') . ' ' . $this->unidad_medida;
    }

    public function descontarStock(float $cantidad, ?int $userId = null, ?string $descripcion = null): void
    {
        if (!$this->controlaStock()) {
            return;
        }

        $stockAntes = (float) $this->stock_actual;
        $stockDespues = round($stockAntes - $cantidad, 2);

        $this->forceFill(['stock_actual' => $stockDespues])->save();
        $this->registrarMovimientoStock('venta', $cantidad, $stockAntes, $stockDespues, $userId, $descripcion);
    }

    public function recargarStock(float $cantidad, ?int $userId = null, ?string $descripcion = null): void
    {
        $stockAntes = (float) $this->stock_actual;
        $stockDespues = round($stockAntes + $cantidad, 2);

        $this->forceFill([
            'stock_actual' => $stockDespues,
            'controla_stock' => true,
        ])->save();

        $this->registrarMovimientoStock('recarga', $cantidad, $stockAntes, $stockDespues, $userId, $descripcion);
    }

    public function registrarMovimientoStock(
        string $tipo,
        float $cantidad,
        float $stockAntes,
        float $stockDespues,
        ?int $userId = null,
        ?string $descripcion = null
    ): void {
        $this->movimientosStock()->create([
            'producto_variedad_id' => null,
            'user_id' => $userId,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'stock_antes' => $stockAntes,
            'stock_despues' => $stockDespues,
            'descripcion' => $descripcion,
        ]);
    }
}
