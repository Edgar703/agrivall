<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Http\Requests\ReservaRequest;
use App\Mail\ReservaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Si es admin y viene por ruta admin, verifica permiso
        if (request()->routeIs('admin.reservas.index')) {
            abort_if($user->role !== 'admin', 403);
        }

        if ($user->role === 'admin') {
            // Admin ve todas las reservas
            $reservas = Reserva::with(['usuario', 'semanaCasilla'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Si viene por ruta admin, usa vista admin
            if (request()->routeIs('admin.reservas.index')) {
                return view('admin.reservas.index', compact('reservas'));
            }
        } else {
            // Usuario ve solo sus reservas
            $reservas = Reserva::with(['usuario', 'semanaCasilla'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rangosNoDisponibles = $this->getDisabledRanges();

        return view('reservas.create', compact('rangosNoDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->startOfDay();

        $overlap = Reserva::where('estado', '!=', 'cancelada')
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                    ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->where('fecha_inicio', '<=', $fechaInicio)
                            ->where('fecha_fin', '>=', $fechaFin);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Las fechas seleccionadas ya no estan disponibles.');
        }

        // Calcular precio automáticamente
        $preciosPorNoche = config('reservas.precio_por_noche', 50);
        $numNoches = $fechaFin->diffInDays($fechaInicio) ?: 1;
        $numPersonas = $request->num_personas;
        
        // Multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($numPersonas - 1) * 0.10);
        $precioTotal = $preciosPorNoche * $numNoches * $multiplicador;

        // Crear la reserva con estado confirmada
        $reserva = Auth::user()->reservas()->create([
            'fecha_inicio' => $fechaInicio->toDateString(),
            'fecha_fin' => $fechaFin->toDateString(),
            'num_personas' => $numPersonas,
            'comentario' => $request->comentario,
            'estado' => 'confirmada',
            'precio_por_noche' => $preciosPorNoche,
            'precio_total' => $precioTotal,
        ]);

        // Enviar correo de confirmación
        Mail::to($reserva->usuario->email)->send(new ReservaMail($reserva));

        return redirect()->route('reservas.show', $reserva->id)
            ->with('success', '¡Reserva creada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $this->authorize('view', $reserva);

        return view('reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        $this->authorize('update', $reserva);
        $rangosNoDisponibles = $this->getDisabledRanges($reserva);

        return view('reservas.edit', compact('reserva', 'rangosNoDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->startOfDay();

        $overlap = Reserva::where('estado', '!=', 'cancelada')
            ->where('id', '!=', $reserva->id)
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                    ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->where('fecha_inicio', '<=', $fechaInicio)
                            ->where('fecha_fin', '>=', $fechaFin);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Las fechas seleccionadas ya no estan disponibles.');
        }

        // Recalcular precio si cambian fechas o número de personas
        $numNoches = $fechaFin->diffInDays($fechaInicio) ?: 1;
        $numPersonas = $request->num_personas;
        $preciosPorNoche = $reserva->precio_por_noche ?? config('reservas.precio_por_noche', 50);
        
        // Multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($numPersonas - 1) * 0.10);
        $precioTotal = $preciosPorNoche * $numNoches * $multiplicador;

        $reserva->update([
            'fecha_inicio' => $fechaInicio->toDateString(),
            'fecha_fin' => $fechaFin->toDateString(),
            'num_personas' => $numPersonas,
            'comentario' => $request->comentario,
            'estado' => $request->estado ?? $reserva->estado,
            'precio_total' => $precioTotal,
        ]);

        if ($request->filled('estado')) {
            $reserva->update(['estado' => $request->estado]);
        }

        return redirect()->route('reservas.show', $reserva->id)
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage (cancelar).
     */
    public function destroy(Reserva $reserva)
    {
        $this->authorize('delete', $reserva);

        // Cambiar estado de reserva a cancelada
        $reserva->update(['estado' => 'cancelada']);

        // Si es admin, redirige al panel de admin, si no a sus reservas
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva cancelada exitosamente.');
        }

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva cancelada exitosamente.');
    }

    /**
     * Cambiar el estado de una reserva (solo admin)
     */
    public function cambiarEstado(Request $request, Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada',
        ]);

        $estadoAnterior = $reserva->estado;
        $reserva->update(['estado' => $request->estado]);

        return redirect()->back()
            ->with('success', 'Estado de reserva actualizado.');
    }

    private function getDisabledRanges(?Reserva $ignorarReserva = null): array
    {
        return Reserva::where('estado', '!=', 'cancelada')
            ->when($ignorarReserva, function ($query) use ($ignorarReserva) {
                $query->where('id', '!=', $ignorarReserva->id);
            })
            ->get(['fecha_inicio', 'fecha_fin'])
            ->map(function ($reserva) {
                return [
                    'from' => $reserva->fecha_inicio->toDateString(),
                    'to' => $reserva->fecha_fin->toDateString(),
                ];
            })
            ->all();
    }
}
