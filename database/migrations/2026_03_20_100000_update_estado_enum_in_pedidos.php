<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pedidos')->where('estado', 'Pendiente')->update(['estado' => 'Iniciado']);
        DB::table('pedidos')->where('estado', 'Pagado')->update(['estado' => 'En proceso']);
        DB::table('pedidos')->where('estado', 'Enviado')->update(['estado' => 'Reparto']);
        DB::table('pedidos')->where('estado', 'Cancelado')->update(['estado' => 'Finalizado']);

        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Iniciado', 'En proceso', 'Reparto', 'Finalizado') DEFAULT 'Iniciado'");
    }

    public function down(): void
    {
        DB::table('pedidos')->where('estado', 'Iniciado')->update(['estado' => 'Pendiente']);
        DB::table('pedidos')->where('estado', 'En proceso')->update(['estado' => 'Pagado']);
        DB::table('pedidos')->where('estado', 'Reparto')->update(['estado' => 'Enviado']);
        DB::table('pedidos')->where('estado', 'Finalizado')->update(['estado' => 'Cancelado']);

        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Pendiente', 'Pagado', 'Enviado', 'Cancelado') DEFAULT 'Pendiente'");
    }
};
