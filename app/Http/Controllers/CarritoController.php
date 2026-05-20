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
<<<<<<< HEAD
        $items = $this->buildCartItems(session('carrito', []));
        $total = round($items->sum('subtotal'), 2);

        return view('carrito.index', [
            'productos' => $items->all(),
            'total' => $total,
        ]);
=======
        // Obtener carrito guardado en sesión
        $carrito = session('carrito', []);
        $productos = [];
        $total = 0;

        // Si hay productos en el carrito, cargarlos desde la base de datos
        if (!empty($carrito)) {
            $productosDb = Producto::whereIn('id', array_keys($carrito))->get()->keyBy('id');

            // Calcular subtotal de cada producto
            foreach ($carrito as $productoId => $item) {
                if ($productosDb->has($productoId)) {
                    $producto = $productosDb[$productoId];
                    $subtotal = $producto->precio * $item['cantidad'];
                    $productos[] = [
                        'producto' => $producto,
                        'cantidad' => $item['cantidad'],
                        'subtotal' => $subtotal,
                    ];
                    $total += $subtotal;
                }
            }
        }

        // Mostrar carrito con productos y total
        return view('carrito.index', compact('productos', 'total'));
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
    }

    public function add(Request $request)
    {
<<<<<<< HEAD
        $producto = Producto::with(['variedades' => fn ($query) => $query->where('activo', true)])
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

=======
        // Validar producto y cantidad
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'integer|min:1|max:99',
        ]);

        // Buscar producto activo
        $producto = Producto::where('id', $request->producto_id)
            ->where('activo', true)
            ->firstOrFail();

        // Obtener carrito actual
        $carrito = session('carrito', []);
        $id = $producto->id;
        $cantidad = $request->input('cantidad', 1);

        // Si ya existe, sumar cantidad; si no, añadirlo
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = ['cantidad' => $cantidad];
        }

        // Guardar carrito en sesión
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
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

<<<<<<< HEAD
        if (!isset($carrito[$itemKey])) {
            return redirect()->route('carrito.index')->with('error', 'La línea del carrito ya no existe.');
        }

        $producto = Producto::with(['variedades' => fn ($query) => $query->where('activo', true)])
            ->where('id', $carrito[$itemKey]['producto_id'])
            ->where('activo', true)
            ->firstOrFail();

        $variedad = $this->resolveVariedad($producto, $carrito[$itemKey]['variedad_id'] ?? null);
        $cantidad = $this->validateCantidad($request, $producto);

        $carrito[$itemKey]['cantidad'] = $cantidad;
        $carrito[$itemKey]['precio_unitario'] = (float) ($variedad?->precio ?? $producto->precio);
        session(['carrito' => $carrito]);

=======
        // Actualizar cantidad si el producto existe en el carrito
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $request->cantidad;
            session(['carrito' => $carrito]);
        }

        // Volver al carrito
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada ✅');
    }

    public function remove(string $itemKey)
    {
        // Obtener carrito actual
        $carrito = session('carrito', []);
<<<<<<< HEAD
        unset($carrito[$itemKey]);
=======

        // Quitar producto del carrito
        unset($carrito[$productoId]);

        // Guardar carrito actualizado
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
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
