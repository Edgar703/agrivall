<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);
        $productos = [];
        $total = 0;

        if (!empty($carrito)) {
            $productosDb = Producto::whereIn('id', array_keys($carrito))->get()->keyBy('id');

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

        return view('carrito.index', compact('productos', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'integer|min:1|max:99',
        ]);

        $producto = Producto::where('id', $request->producto_id)
            ->where('activo', true)
            ->firstOrFail();

        $carrito = session('carrito', []);
        $id = $producto->id;
        $cantidad = $request->input('cantidad', 1);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = ['cantidad' => $cantidad];
        }

        session(['carrito' => $carrito]);

        return redirect()->back()->with('success', 'Producto añadido al carrito ✅');
    }

    public function update(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1|max:99',
        ]);

        $carrito = session('carrito', []);
        $id = $request->producto_id;

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $request->cantidad;
            session(['carrito' => $carrito]);
        }

        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada ✅');
    }

    public function remove($productoId)
    {
        $carrito = session('carrito', []);
        unset($carrito[$productoId]);
        session(['carrito' => $carrito]);

        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito ✅');
    }

    public function clear()
    {
        session()->forget('carrito');

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado ✅');
    }
}
