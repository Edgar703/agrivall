<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pedidos')
            ->whereIn('metodo_pago', ['Visa', 'Efectivo'])
            ->update(['metodo_pago' => 'Bizzum']);

        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago ENUM('Bizzum', 'Transferencia') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago ENUM('Visa', 'Efectivo', 'Bizzum', 'Transferencia') NOT NULL");
    }
};
