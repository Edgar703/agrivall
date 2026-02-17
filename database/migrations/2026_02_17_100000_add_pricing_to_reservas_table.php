<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->decimal('precio_por_noche', 8, 2)->default(50)->after('num_personas');
            $table->decimal('multiplicador_personas', 3, 2)->default(1.0)->after('precio_por_noche');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('precio_por_noche');
            $table->dropColumn('multiplicador_personas');
        });
    }
};
