<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductoVariedad extends Model
{
    protected $table = 'producto_variedades';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'nombre',
        'precio',
        'stock_actual',
        'stock_minimo',
        'controla_stock',
        'activo',
        'orden',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'controla_stock' => 'boolean',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function movimientosStock(): HasMany
    {
        return $this->hasMany(MovimientoStock::class, 'producto_variedad_id')->latest();
    }

    public function controlaStock(): bool
    {
        return (bool) $this->controla_stock;
    }

    public function tieneStock(float $cantidad): bool
    {
        return !$this->controlaStock() || (float) $this->stock_actual >= $cantidad;
    }

    public function estaAgotada(): bool
    {
        return $this->controlaStock() && (float) $this->stock_actual <= 0;
    }

    public function tieneStockBajo(): bool
    {
        return $this->controlaStock()
            && (float) $this->stock_actual > 0
            && (float) $this->stock_actual <= (float) $this->stock_minimo;
    }

    public function etiquetaStock(?string $unidad = null): string
    {
        if (!$this->controlaStock()) {
            return 'Disponible';
        }

        $unidad ??= $this->producto?->unidad_medida ?? 'ud';

        return rtrim(rtrim(number_format((float) $this->stock_actual, 2, ',', '.'), '0'), ',') . ' ' . $unidad;
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
        MovimientoStock::create([
            'producto_id' => $this->producto_id,
            'producto_variedad_id' => $this->id,
            'user_id' => $userId,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'stock_antes' => $stockAntes,
            'stock_despues' => $stockDespues,
            'descripcion' => $descripcion,
        ]);
    }
}
