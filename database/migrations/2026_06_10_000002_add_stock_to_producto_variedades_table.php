<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('producto_variedades')) {
            Schema::table('producto_variedades', function (Blueprint $table) {
                if (!Schema::hasColumn('producto_variedades', 'stock_actual')) {
                    $table->decimal('stock_actual', 10, 2)->default(0)->after('precio');
                }

                if (!Schema::hasColumn('producto_variedades', 'stock_minimo')) {
                    $table->decimal('stock_minimo', 10, 2)->default(0)->after('stock_actual');
                }

                if (!Schema::hasColumn('producto_variedades', 'controla_stock')) {
                    $table->boolean('controla_stock')->default(true)->after('stock_minimo');
                }
            });
        }

        if (
            Schema::hasTable('movimientos_stock')
            && Schema::hasTable('producto_variedades')
            && !Schema::hasColumn('movimientos_stock', 'producto_variedad_id')
        ) {
            Schema::table('movimientos_stock', function (Blueprint $table) {
                $table->foreignId('producto_variedad_id')
                    ->nullable()
                    ->after('producto_id')
                    ->constrained('producto_variedades')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('movimientos_stock') && Schema::hasColumn('movimientos_stock', 'producto_variedad_id')) {
            Schema::table('movimientos_stock', function (Blueprint $table) {
                $table->dropConstrainedForeignId('producto_variedad_id');
            });
        }

        if (Schema::hasTable('producto_variedades')) {
            Schema::table('producto_variedades', function (Blueprint $table) {
                foreach (['stock_actual', 'stock_minimo', 'controla_stock'] as $column) {
                    if (Schema::hasColumn('producto_variedades', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
