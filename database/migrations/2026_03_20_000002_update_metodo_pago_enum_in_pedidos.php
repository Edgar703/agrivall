<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove PayPal and credit card options, keep only Bizzum and Transferencia
        // First, update any existing records with removed payment methods to a default one
        DB::table('pedidos')
            ->whereIn('metodo_pago', ['Visa', 'Efectivo'])
            ->update(['metodo_pago' => 'Bizzum']);

        // Convert to VARCHAR first to avoid constraint issues
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago ENUM('Bizzum', 'Transferencia') NOT NULL");
    }

    public function down(): void
    {
        // Restore the original payment methods
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago VARCHAR(50)");
        DB::statement("ALTER TABLE pedidos MODIFY metodo_pago ENUM('Visa', 'Efectivo', 'Bizzum', 'Transferencia') NOT NULL");
    }
};
