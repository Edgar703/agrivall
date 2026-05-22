<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoVariedad;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CarritoController extends Controller
{
    public function index()
    {
        $items = $this->buildCartItems(session('carrito', []));
        $total = round($items->sum('subtotal'), 2);

        return view('carrito.index', [
            'productos' => $items->all(),
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $producto = Producto::with(['variedades' => fn($query) => $query->where('activo', true)])
            ->where('id', $request->input('producto_id'))
            ->where('activo', true)
            ->firstOrFail();

        $variedad = $this->resolveVariedad($producto, $request->input('variedad_id'));
        $cantidad = $this->validateCantidad($request, $producto);

        $carrito = session('carrito', []);
        $itemKey = $this->makeItemKey($producto->id, $variedad?->id);
        $precioUnitario = $variedad?->precio ?? $producto->precio;

        if (isset($carrito[$itemKey])) {
            $cantidad += (float) $carrito[$itemKey]['cantidad'];
            $this->assertQuantityMatchesStep($cantidad, (float) $producto->step_cantidad, $producto->tipo_venta);
        }

        $carrito[$itemKey] = [
            'producto_id' => $producto->id,
            'variedad_id' => $variedad?->id,
            'cantidad' => $cantidad,
            'tipo_venta' => $producto->tipo_venta,
            'unidad_medida' => $producto->unidad_medida,
            'step_cantidad' => (float) $producto->step_cantidad,
            'precio_unitario' => (float) $precioUnitario,
        ];

        session(['carrito' => $carrito]);

        // Volver atrás con mensaje
        return redirect()->back()->with('success', 'Producto añadido al carrito ✅');
    }

    public function update(Request $request)
    {
        // Validar nueva cantidad
        $request->validate([
            'item_key' => 'required|string',
            'cantidad' => 'required',
        ]);

        // Obtener carrito actual
        $carrito = session('carrito', []);
        $itemKey = $request->input('item_key');

        if (!isset($carrito[$itemKey])) {
            return redirect()->route('carrito.index')->with('error', 'La línea del carrito ya no existe.');
        }

        $producto = Producto::with(['variedades' => fn($query) => $query->where('activo', true)])
            ->where('id', $carrito[$itemKey]['producto_id'])
            ->where('activo', true)
            ->firstOrFail();

        $variedad = $this->resolveVariedad($producto, $carrito[$itemKey]['variedad_id'] ?? null);
        $cantidad = $this->validateCantidad($request, $producto);

        $carrito[$itemKey]['cantidad'] = $cantidad;
        $carrito[$itemKey]['precio_unitario'] = (float) ($variedad?->precio ?? $producto->precio);
        session(['carrito' => $carrito]);

        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada ✅');
    }

    public function remove(string $itemKey)
    {
        // Obtener carrito actual
        $carrito = session('carrito', []);
        unset($carrito[$itemKey]);
        session(['carrito' => $carrito]);

        // Volver al carrito
        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito ✅');
    }

    public function clear()
    {
        // Eliminar carrito completo de la sesión
        session()->forget('carrito');

        // Volver al carrito vacío
        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado ✅');
    }

    public function buildCartItems(array $cart): Collection
    {
        if (empty($cart)) {
            return collect();
        }

        $productos = Producto::with(['categoria', 'variedades'])
            ->whereIn('id', collect($cart)->pluck('producto_id')->unique()->all())
            ->get()
            ->keyBy('id');

        $items = collect();

        foreach ($cart as $itemKey => $entry) {
            if (!isset($entry['producto_id'])) {
                $entry = [
                    'producto_id' => is_numeric($itemKey) ? (int) $itemKey : null,
                    'variedad_id' => null,
                    'cantidad' => (float) ($entry['cantidad'] ?? 0),
                ];
            }

            $producto = $productos->get($entry['producto_id']);
            if (!$producto || !$producto->activo) {
                continue;
            }

            $variedad = null;
            if (!empty($entry['variedad_id'])) {
                $variedad = $producto->variedades->firstWhere('id', (int) $entry['variedad_id']);
                if (!$variedad || !$variedad->activo) {
                    continue;
                }
            }

            $precioUnitario = round((float) ($variedad?->precio ?? $producto->precio), 2);
            $cantidad = (float) $entry['cantidad'];
            $subtotal = round($precioUnitario * $cantidad, 2);

            $items->push([
                'item_key' => $itemKey,
                'producto' => $producto,
                'variedad' => $variedad,
                'cantidad' => $cantidad,
                'tipo_venta' => $producto->tipo_venta,
                'unidad_medida' => $producto->unidad_medida,
                'step_cantidad' => (float) $producto->step_cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $subtotal,
            ]);
        }

        return $items;
    }

    private function resolveVariedad(Producto $producto, $variedadId): ?ProductoVariedad
    {
        if (!$variedadId) {
            return null;
        }

        $variedad = $producto->variedades->firstWhere('id', (int) $variedadId);

        if (!$variedad) {
            throw ValidationException::withMessages([
                'variedad_id' => 'La variedad seleccionada no es válida para este producto.',
            ]);
        }

        return $variedad;
    }

    private function validateCantidad(Request $request, Producto $producto): float
    {
        $raw = str_replace(',', '.', (string) $request->input('cantidad'));

        if (!is_numeric($raw)) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad indicada no es válida.',
            ]);
        }

        $cantidad = (float) $raw;
        if ($cantidad <= 0) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad debe ser mayor que cero.',
            ]);
        }

        $step = (float) $producto->step_cantidad;
        $this->assertQuantityMatchesStep($cantidad, $step, $producto->tipo_venta);

        return round($cantidad, 2);
    }

    private function assertQuantityMatchesStep(float $cantidad, float $step, string $tipoVenta): void
    {
        if ($tipoVenta === 'unidad' && floor($cantidad) !== $cantidad) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad debe ser entera para productos por unidad.',
            ]);
        }

        if ($step <= 0) {
            return;
        }

        $ratio = $cantidad / $step;
        if (abs($ratio - round($ratio)) > 0.00001) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad debe respetar incrementos de ' . rtrim(rtrim(number_format($step, 2, '.', ''), '0'), '.') . '.',
            ]);
        }
    }

    private function makeItemKey(int $productoId, ?int $variedadId): string
    {
        return $productoId . '-' . ($variedadId ?? 0);
    }
}
