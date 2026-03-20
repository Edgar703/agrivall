<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPedidoController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $query = Pedido::with('usuario')->withCount('lineas');

        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('nombre_cliente', 'like', "%{$term}%")
                    ->orWhere('email_cliente', 'like', "%{$term}%")
                    ->orWhere('id', $term);
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        $pedidos = $query->orderBy('fecha_pedido', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total' => Pedido::count(),
            'iniciados' => Pedido::where('estado', 'Iniciado')->count(),
            'en_proceso' => Pedido::where('estado', 'En proceso')->count(),
            'reparto' => Pedido::where('estado', 'Reparto')->count(),
            'finalizados' => Pedido::where('estado', 'Finalizado')->count(),
        ];

        return view('admin.pedidos.index', compact('pedidos', 'stats'));
    }

    public function show(Pedido $pedido)
    {
        $this->ensureAdmin();

        $pedido->load('lineas.producto', 'usuario');

        return view('admin.pedidos.show', compact('pedido'));
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $this->ensureAdmin();

        $request->validate([
            'estado' => 'required|in:Iniciado,En proceso,Reparto,Finalizado',
        ]);

        $pedido->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado ✅');
    }

    public function destroy(Pedido $pedido)
    {
        $this->ensureAdmin();

        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido #' . $pedido->id . ' eliminado correctamente ✅');
    }
}
