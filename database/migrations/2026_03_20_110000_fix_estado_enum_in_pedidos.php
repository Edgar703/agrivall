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
        // First, let's check what values currently exist in the estado column
        // and convert them to the new enum values if needed
        $existingStates = DB::table('pedidos')
            ->distinct()
            ->pluck('estado')
            ->toArray();

        // Map old states to new states if necessary
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

        // Update any old state values to new ones
        foreach ($existingStates as $state) {
            if (isset($stateMapping[$state]) && $stateMapping[$state] !== $state) {
                DB::table('pedidos')
                    ->where('estado', $state)
                    ->update(['estado' => $stateMapping[$state]]);
            }
        }

        // Now modify the ENUM column - using a safer approach
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado VARCHAR(50)");

        // Update to the enum values
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Iniciado', 'En proceso', 'Reparto', 'Finalizado') DEFAULT 'Iniciado'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old enum values
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
