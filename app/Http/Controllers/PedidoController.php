<?php

namespace App\Http\Controllers;

use App\Mail\PedidoCanceladoMail;
use App\Mail\PedidoMail;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public function checkout()
    {
        $carritoController = app(CarritoController::class);
        $items = $carritoController->buildCartItems(session('carrito', []));

        if ($items->isEmpty()) {
            session()->forget('carrito');
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = round($items->sum('subtotal'), 2);
        $user = Auth::user();

        // Mostrar pantalla de checkout
        return view('pedidos.checkout', compact('items', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $carritoController = app(CarritoController::class);
        $items = $carritoController->buildCartItems(session('carrito', []));

        if ($items->isEmpty()) {
            session()->forget('carrito');
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Validar datos del pedido
        $validated = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'email_cliente' => 'required|email|max:255',
            'tlf_cliente' => 'required|string|max:15',
            'direccion_envio' => 'required|string|max:500',
            'metodo_pago' => 'required|in:Bizzum,Transferencia',
        ]);

        $pedido = DB::transaction(function () use ($validated, $items) {
            $total = round($items->sum('subtotal'), 2);

            // Crear pedido principal
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

            foreach ($items as $item) {
                $pedido->lineas()->create([
                    'producto_id' => $item['producto']->id,
                    'producto_variedad_id' => $item['variedad']?->id,
                    'nombre_producto' => $item['producto']->nombre,
                    'nombre_variedad' => $item['variedad']?->nombre,
                    'tipo_venta' => $item['tipo_venta'],
                    'unidad_medida' => $item['unidad_medida'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Devolver pedido creado
            return $pedido;
        });

        // Vaciar carrito después de comprar
        session()->forget('carrito');

        // Cargar líneas y productos para emails
        $pedido->load('lineas.producto');

        // Enviar email al admin y al cliente
        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new PedidoMail($pedido, true));
        Mail::to($pedido->email_cliente)->send(new PedidoMail($pedido));

        // Mostrar detalle del pedido creado
        return redirect()->route('pedidos.show', $pedido)
            ->with('success', '¡Pedido realizado con éxito! ✅');
    }

    public function show(Pedido $pedido)
    {
        // Obtener usuario logueado
        $user = Auth::user();

        // Permitir solo admin o dueño del pedido
        if ($user->role !== 'admin' && $pedido->user_id !== $user->id) {
            abort(403);
        }

        // Cargar productos del pedido
        $pedido->load('lineas.producto');

        // Mostrar detalle del pedido
        return view('pedidos.show', compact('pedido'));
    }

    public function misPedidos()
    {
        // Buscar pedidos del usuario logueado
        $pedidos = Pedido::where('user_id', Auth::id())
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        // Mostrar listado de mis pedidos
        return view('pedidos.mis-pedidos', compact('pedidos'));
    }

    public function destroy(Pedido $pedido)
    {
        // Comprobar que el pedido sea del usuario logueado
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        // Cargar productos para email de cancelación
        $pedido->load('lineas.producto');

        // Enviar email de cancelación al admin y al cliente
        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new PedidoCanceladoMail($pedido, true));
        Mail::to($pedido->email_cliente)->send(new PedidoCanceladoMail($pedido));

        // Eliminar pedido
        $pedido->delete();

        // Volver a mis pedidos
        return redirect()->route('pedidos.misPedidos')->with('success', 'Pedido #' . $pedido->id . ' eliminado correctamente ✅');
    }
}
