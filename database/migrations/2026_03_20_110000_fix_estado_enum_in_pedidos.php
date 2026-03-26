<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $existingStates = DB::table('pedidos')
            ->distinct()
            ->pluck('estado')
            ->toArray();

        $stateMapping = [
            'Pendiente' => 'Iniciado',
            'Pagado' => 'En proceso',
            'Enviado' => 'Reparto',
            'Cancelado' => 'Finalizado',
            'Iniciado' => 'Iniciado',
            'En proceso' => 'En proceso',
            'Reparto' => 'Reparto',
            'Finalizado' => 'Finalizado',
        ];

        foreach ($existingStates as $state) {
            if (isset($stateMapping[$state]) && $stateMapping[$state] !== $state) {
                DB::table('pedidos')
                    ->where('estado', $state)
                    ->update(['estado' => $stateMapping[$state]]);
            }
        }

        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Iniciado', 'En proceso', 'Reparto', 'Finalizado') DEFAULT 'Iniciado'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('pedidos')
            ->where('estado', 'Iniciado')
            ->update(['estado' => 'Pendiente']);

        DB::table('pedidos')
            ->where('estado', 'En proceso')
            ->update(['estado' => 'Pagado']);

        DB::table('pedidos')
            ->where('estado', 'Reparto')
            ->update(['estado' => 'Enviado']);

        DB::table('pedidos')
            ->where('estado', 'Finalizado')
            ->update(['estado' => 'Cancelado']);

        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Pendiente', 'Pagado', 'Enviado', 'Cancelado') DEFAULT 'Pendiente'");
    }
};
