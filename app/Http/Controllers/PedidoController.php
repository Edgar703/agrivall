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
<<<<<<< HEAD
        $carritoController = app(CarritoController::class);
        $items = $carritoController->buildCartItems(session('carrito', []));

        if ($items->isEmpty()) {
            session()->forget('carrito');
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = round($items->sum('subtotal'), 2);
=======
        // Obtener carrito guardado en sesión
        $carrito = session('carrito', []);

        // Si el carrito está vacío, volver al carrito
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Cargar productos del carrito desde la base de datos
        $productosDb = Producto::whereIn('id', array_keys($carrito))->get()->keyBy('id');
        $items = [];
        $total = 0;

        // Preparar productos y calcular total
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

        // Obtener usuario logueado para rellenar datos
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
        $user = Auth::user();

        // Mostrar pantalla de checkout
        return view('pedidos.checkout', compact('items', 'total', 'user'));
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        $carritoController = app(CarritoController::class);
        $items = $carritoController->buildCartItems(session('carrito', []));

        if ($items->isEmpty()) {
            session()->forget('carrito');
=======
        // Obtener carrito guardado en sesión
        $carrito = session('carrito', []);

        // Si el carrito está vacío, volver al carrito
        if (empty($carrito)) {
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
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

<<<<<<< HEAD
        $pedido = DB::transaction(function () use ($validated, $items) {
            $total = round($items->sum('subtotal'), 2);
=======
        // Cargar productos activos del carrito
        $productosDb = Producto::whereIn('id', array_keys($carrito))
            ->where('activo', true)
            ->get()
            ->keyBy('id');

        // Si no hay productos disponibles, vaciar carrito
        if ($productosDb->isEmpty()) {
            session()->forget('carrito');
            return redirect()->route('productos.catalogo')->with('error', 'Los productos del carrito ya no están disponibles.');
        }

        // Crear pedido y líneas dentro de una transacción
        $pedido = DB::transaction(function () use ($validated, $carrito, $productosDb) {
            $total = 0;
            $lineas = [];

            // Calcular total y preparar líneas del pedido
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
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)

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

<<<<<<< HEAD
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
=======
            // Crear líneas del pedido
            foreach ($lineas as $linea) {
                $pedido->lineas()->create($linea);
>>>>>>> 8583b55 (Añadi comentarios en el codigo.)
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
