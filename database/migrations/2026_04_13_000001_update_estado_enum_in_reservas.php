<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrar valores existentes al nuevo esquema
        DB::table('reservas')->where('estado', 'pendiente')->update(['estado' => 'PRE-RESERVA']);
        DB::table('reservas')->where('estado', 'confirmada')->update(['estado' => 'RESERVADO']);
        // 'cancelada' se mantiene igual

        DB::statement("ALTER TABLE reservas MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE reservas MODIFY COLUMN estado ENUM('PRE-RESERVA','RESERVADO','NO_DISPONIBLE','cancelada') NOT NULL DEFAULT 'PRE-RESERVA'");
    }

    public function down(): void
    {
        DB::table('reservas')->where('estado', 'PRE-RESERVA')->update(['estado' => 'pendiente']);
        DB::table('reservas')->where('estado', 'RESERVADO')->update(['estado' => 'confirmada']);
        DB::table('reservas')->where('estado', 'NO_DISPONIBLE')->update(['estado' => 'cancelada']);

        DB::statement("ALTER TABLE reservas MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE reservas MODIFY COLUMN estado ENUM('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente'");
    }
};
