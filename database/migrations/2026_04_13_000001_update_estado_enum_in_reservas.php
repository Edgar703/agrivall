<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Primero liberar la restricción del ENUM convirtiéndolo a VARCHAR
        DB::statement("ALTER TABLE reservas MODIFY COLUMN estado VARCHAR(50) NOT NULL DEFAULT 'pendiente'");

        // 2. Ahora sí migrar los valores existentes (sin restricción de enum)
        DB::table('reservas')->where('estado', 'pendiente')->update(['estado' => 'PRE-RESERVA']);
        DB::table('reservas')->where('estado', 'confirmada')->update(['estado' => 'RESERVADO']);
        // 'cancelada' se mantiene igual

        // 3. Aplicar el nuevo ENUM con los valores correctos
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
