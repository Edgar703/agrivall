<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Usuario;
use App\Http\Requests\ReservaRequest;
use App\Mail\ReservaMail;
use App\Mail\ReservaAdminMail;
use App\Mail\ReservaCanceladaMail;
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
            $reservas = Reserva::with('usuario')
                ->orderBy('created_at', 'desc')
                ->get();

            // Si viene por ruta admin, usa vista admin
            if (request()->routeIs('admin.reservas.index')) {
                return view('admin.reservas.index', compact('reservas'));
            }
        } else {
            // Usuario ve solo sus reservas
            $reservas = Reserva::with('usuario')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Obtener rangos de fechas que no se pueden reservar
        $rangosNoDisponibles = $this->getDisabledRanges();

        // Capturar datos del widget (query params)
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');
        $numPersonas = $request->query('num_personas');

        // Mostrar formulario de creación de reserva
        return view('reservas.create', compact(
            'rangosNoDisponibles',
            'fechaInicio',
            'fechaFin',
            'numPersonas'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        // Convertir las fechas recibidas a formato Carbon
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->startOfDay();

        // Comprobar si las fechas chocan con otra reserva activa
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

        // Si ya existe una reserva en esas fechas, vuelve al formulario
        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Las fechas seleccionadas ya no estan disponibles.');
        }

        // Calcular precio automáticamente
        $preciosPorNoche = config('reservas.precio_por_noche', 50);
        $numNoches = $fechaInicio->diffInDays($fechaFin) ?: 1;
        $numPersonas = $request->num_personas;

        // Multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($numPersonas - 1) * 0.10);
        $precioTotal = $preciosPorNoche * $numNoches * $multiplicador;

        // Crear la reserva con estado PRE-RESERVA (pendiente de confirmación por el admin)
        /** @var Usuario $user */
        $user = $request->user();

        // Guardar la reserva asociada al usuario logueado
        $reserva = $user->reservas()->create([
            'fecha_inicio' => $fechaInicio->toDateString(),
            'fecha_fin' => $fechaFin->toDateString(),
            'num_personas' => $numPersonas,
            'comentario' => $request->comentario,
            'estado' => 'PRE-RESERVA',
            'precio_por_noche' => $preciosPorNoche,
            'multiplicador_personas' => $multiplicador,
            'precio_total' => $precioTotal,
        ]);

        // Cargar los datos del usuario para enviar emails
        $reserva->load('usuario');

        // Notificar al cliente que su solicitud fue recibida
        Mail::to($reserva->usuario->email)->send(new ReservaMail($reserva));

        // Notificar al admin para que confirme o rechace
        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new ReservaAdminMail($reserva));

        // Redirigir al detalle de la reserva creada
        return redirect()->route('reservas.show', $reserva->id)
            ->with('success', '¡Solicitud de reserva enviada! Te confirmaremos en breve por email. ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        // Comprobar si el usuario puede ver esta reserva
        $this->authorize('view', $reserva);

        // Mostrar detalle de la reserva
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        // Comprobar si el usuario puede editar esta reserva
        $this->authorize('update', $reserva);

        // Obtener fechas bloqueadas ignorando la reserva actual
        $rangosNoDisponibles = $this->getDisabledRanges($reserva);

        // Mostrar formulario de edición
        return view('reservas.edit', compact('reserva', 'rangosNoDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, Reserva $reserva)
    {
        // Comprobar si el usuario puede actualizar esta reserva
        $this->authorize('update', $reserva);

        // Convertir las fechas recibidas a formato Carbon
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->startOfDay();

        // Comprobar si las nuevas fechas chocan con otra reserva activa
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

        // Si las fechas no están disponibles, vuelve al formulario
        if ($overlap) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Las fechas seleccionadas ya no estan disponibles.');
        }

        // Recalcular precio si cambian fechas o número de personas
        $numNoches = $fechaInicio->diffInDays($fechaFin) ?: 1;
        $numPersonas = $request->num_personas;
        $preciosPorNoche = $reserva->precio_por_noche ?? config('reservas.precio_por_noche', 50);

        // Multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($numPersonas - 1) * 0.10);
        $precioTotal = $preciosPorNoche * $numNoches * $multiplicador;

        // Actualizar datos de la reserva
        $reserva->update([
            'fecha_inicio' => $fechaInicio->toDateString(),
            'fecha_fin' => $fechaFin->toDateString(),
            'num_personas' => $numPersonas,
            'comentario' => $request->comentario,
            'estado' => $request->estado ?? $reserva->estado,
            'multiplicador_personas' => $multiplicador,
            'precio_total' => $precioTotal,
        ]);

        // Si llega un estado nuevo, actualizarlo también
        if ($request->filled('estado')) {
            $reserva->update(['estado' => $request->estado]);
        }

        // Redirigir al detalle de la reserva actualizada
        return redirect()->route('reservas.show', $reserva->id)
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage (cancelar).
     */
    public function destroy(Reserva $reserva)
    {
        // Comprobar si el usuario puede cancelar esta reserva
        $this->authorize('delete', $reserva);

        // Cambiar estado de reserva a cancelada
        $reserva->update(['estado' => 'cancelada']);

        // Cargar usuario para enviar emails
        $reserva->load('usuario');

        // Enviar email de cancelación al admin y al cliente
        Mail::to(config('mail.admin_address', config('mail.from.address')))->send(new ReservaCanceladaMail($reserva, true));
        Mail::to($reserva->usuario->email)->send(new ReservaCanceladaMail($reserva));

        // Si es admin, redirige al panel de admin, si no a sus reservas
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.reservas.index')
                ->with('success', 'Reserva #' . $reserva->id . ' cancelada. Las fechas quedan disponibles.');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Tu reserva ha sido cancelada.');
    }

    /**
     * Cambiar el estado de una reserva (solo admin)
     */
    public function cambiarEstado(Request $request, Reserva $reserva)
    {
        // Comprobar si el usuario puede cambiar el estado
        $this->authorize('update', $reserva);

        // Validar que el estado sea correcto
        $request->validate([
            'estado' => 'required|in:PRE-RESERVA,RESERVADO,NO_DISPONIBLE,cancelada',
        ]);

        // Guardar el nuevo estado
        $reserva->update(['estado' => $request->estado]);

        // Mensajes según el estado elegido
        $mensajes = [
            'PRE-RESERVA'   => 'Reserva marcada como PRE-RESERVA.',
            'RESERVADO'     => 'Reserva confirmada como RESERVADO. ✅',
            'NO_DISPONIBLE' => 'Período marcado como NO DISPONIBLE.',
            'cancelada'     => 'Reserva cancelada. Las fechas quedan libres.',
        ];

        // Volver a la página anterior con mensaje
        return redirect()->back()
            ->with('success', $mensajes[$request->estado] ?? 'Estado actualizado.');
    }

    private function getDisabledRanges(?Reserva $ignorarReserva = null): array
    {
        // Buscar reservas activas para bloquear sus fechas
        return Reserva::where('estado', '!=', 'cancelada')
            // Si estamos editando, ignorar la reserva actual
            ->when($ignorarReserva, function ($query) use ($ignorarReserva) {
                $query->where('id', '!=', $ignorarReserva->id);
            })
            ->get(['fecha_inicio', 'fecha_fin'])
            // Convertir cada reserva al formato que necesita el calendario
            ->map(function ($reserva) {
                return [
                    'from' => $reserva->fecha_inicio->toDateString(),
                    'to' => $reserva->fecha_fin->toDateString(),
                ];
            })
            ->all();
    }

    /** Obtener fechas bloqueadas para el widget de reservas **/
    public function fechasBloqueadas()
    {
        // Obtener rangos bloqueados
        $rangos = $this->getDisabledRanges();

        // Devolver los rangos en formato JSON
        return response()->json([
            'success' => true,
            'fechas_bloqueadas' => $rangos
        ]);
    }

    /** Calcular precio de reserva basado en fechas y personas */
    public function calcularPrecioApi(Request $request)
    {
        // Validar datos recibidos desde el widget
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'num_personas' => 'required|integer|min:1|max:10',
        ]);

        // Convertir datos para calcular el precio
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $numPersonas = $request->num_personas;

        // Calcular noches
        $numNoches = $fechaInicio->diffInDays($fechaFin);

        // Validar mínimo 7 días
        if ($numNoches < 7) {
            return response()->json([
                'success' => false,
                'error' => 'La estancia mínima es de 7 días'
            ], 422);
        }

        // Obtener precio base desde config
        $precioBase = config('reservas.precio_por_noche', 50);

        // Calcular multiplicador: +10% por cada persona adicional
        $multiplicador = 1 + (($numPersonas - 1) * 0.10);

        // Calcular precio total
        $precioTotal = $precioBase * $numNoches * $multiplicador;

        // Devolver el precio calculado en JSON
        return response()->json([
            'success' => true,
            'precio_base_noche' => $precioBase,
            'num_noches' => $numNoches,
            'num_personas' => $numPersonas,
            'multiplicador' => round($multiplicador, 2),
            'precio_total' => round($precioTotal, 2)
        ]);
    }
}
