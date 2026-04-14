<?php

namespace App\Http\Controllers;

use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoMail;
use App\Mail\PedidoCanceladoMail;

class PedidoController extends Controller
{
    public function checkout()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $productosDb = Producto::whereIn('id', array_keys($carrito))->get()->keyBy('id');
        $items = [];
        $total = 0;

        foreach ($carrito as $productoId => $item) {
            if ($productosDb->has($productoId)) {
                $producto = $productosDb[$productoId];
                $subtotal = $producto->precio * $item['cantidad'];
                $items[] = [
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        $user = Auth::user();

        return view('pedidos.checkout', compact('items', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $validated = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'email_cliente' => 'required|email|max:255',
            'tlf_cliente' => 'required|string|max:15',
            'direccion_envio' => 'required|string|max:500',
            'metodo_pago' => 'required|in:Bizzum,Transferencia',
        ]);

        $productosDb = Producto::whereIn('id', array_keys($carrito))
            ->where('activo', true)
            ->get()
            ->keyBy('id');

        if ($productosDb->isEmpty()) {
            session()->forget('carrito');
            return redirect()->route('productos.catalogo')->with('error', 'Los productos del carrito ya no están disponibles.');
        }

        $pedido = DB::transaction(function () use ($validated, $carrito, $productosDb) {
            $total = 0;
            $lineas = [];

            foreach ($carrito as $productoId => $item) {
                if ($productosDb->has($productoId)) {
                    $producto = $productosDb[$productoId];
                    $subtotal = $producto->precio * $item['cantidad'];
                    $total += $subtotal;
                    $lineas[] = [
                        'producto_id' => $productoId,
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $producto->precio,
                    ];
                }
            }

            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'fecha_pedido' => now(),
                'nombre_cliente' => $validated['nombre_cliente'],
                'email_cliente' => $validated['email_cliente'],
                'tlf_cliente' => $validated['tlf_cliente'],
                'direccion_envio' => $validated['direccion_envio'],
                'metodo_pago' => $validated['metodo_pago'],
                'precio_pedido' => $total,
                'estado' => 'Iniciado',
            ]);

            foreach ($lineas as $linea) {
                $pedido->lineas()->create($linea);
            }

            return $pedido;
        });

        session()->forget('carrito');

        $pedido->load('lineas.producto');

        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new PedidoMail($pedido, true));
        Mail::to($pedido->email_cliente)->send(new PedidoMail($pedido));

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', '¡Pedido realizado con éxito! ✅');
    }

    public function show(Pedido $pedido)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $pedido->user_id !== $user->id) {
            abort(403);
        }

        $pedido->load('lineas.producto');

        return view('pedidos.show', compact('pedido'));
    }

    public function misPedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        return view('pedidos.mis-pedidos', compact('pedidos'));
    }

    public function destroy(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('lineas.producto');

        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new PedidoCanceladoMail($pedido, true));
        Mail::to($pedido->email_cliente)->send(new PedidoCanceladoMail($pedido));

        $pedido->delete();

        return redirect()->route('pedidos.misPedidos')->with('success', 'Pedido #' . $pedido->id . ' eliminado correctamente ✅');
    }
}
