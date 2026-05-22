<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class AdminPedidoController extends Controller
{
    public function index(Request $request)
    {
        // Preparar consulta con usuario y número de líneas
        $query = Pedido::with('usuario')->withCount('lineas');

        // Filtrar por texto si viene búsqueda
        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('nombre_cliente', 'like', "%{$term}%")
                    ->orWhere('email_cliente', 'like', "%{$term}%")
                    ->orWhere('id', $term);
            });
        }

        // Filtrar por estado si viene seleccionado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Obtener pedidos paginados
        $pedidos = $query->orderBy('fecha_pedido', 'desc')->paginate(15)->withQueryString();

        // Calcular estadísticas por estado
        $stats = [
            'total' => Pedido::count(),
            'iniciados' => Pedido::where('estado', 'Iniciado')->count(),
            'en_proceso' => Pedido::where('estado', 'En proceso')->count(),
            'reparto' => Pedido::where('estado', 'Reparto')->count(),
            'finalizados' => Pedido::where('estado', 'Finalizado')->count(),
        ];

        // Mostrar panel de pedidos
        return view('admin.pedidos.index', compact('pedidos', 'stats'));
    }

    public function show(Pedido $pedido)
    {
        // Cargar líneas, productos y usuario del pedido
        $pedido->load('lineas.producto', 'usuario');

        // Mostrar detalle del pedido
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        // Validar el estado recibido
        $request->validate([
            'estado' => 'required|in:Iniciado,En proceso,Reparto,Finalizado',
        ]);

        // Guardar nuevo estado
        $pedido->update(['estado' => $request->estado]);

        // Volver atrás con mensaje
        return redirect()->back()->with('success', 'Estado del pedido actualizado ✅');
    }

    public function destroy(Pedido $pedido)
    {
        // Eliminar pedido
        $pedido->delete();

        // Volver al listado
        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido #' . $pedido->id . ' eliminado correctamente ✅');
    }
}
