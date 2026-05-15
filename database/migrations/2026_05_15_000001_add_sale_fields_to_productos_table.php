<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('tipo_venta', 20)->default('unidad')->after('precio');
            $table->string('unidad_medida', 10)->default('ud')->after('tipo_venta');
            $table->decimal('step_cantidad', 8, 2)->default(1)->after('unidad_medida');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['tipo_venta', 'unidad_medida', 'step_cantidad']);
        });
    }
};
