<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'stock_actual')) {
                $table->decimal('stock_actual', 10, 2)->default(0)->after('step_cantidad');
            }

            if (!Schema::hasColumn('productos', 'stock_minimo')) {
                $table->decimal('stock_minimo', 10, 2)->default(0)->after('stock_actual');
            }

            if (!Schema::hasColumn('productos', 'controla_stock')) {
                $table->boolean('controla_stock')->default(true)->after('stock_minimo');
            }
        });

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

        if (!Schema::hasTable('movimientos_stock')) {
            Schema::create('movimientos_stock', function (Blueprint $table) {
                $table->id();
                $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
                $table->foreignId('producto_variedad_id')->nullable()->constrained('producto_variedades')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('usuarios')->nullOnDelete();
                $table->string('tipo', 30);
                $table->decimal('cantidad', 10, 2);
                $table->decimal('stock_antes', 10, 2);
                $table->decimal('stock_despues', 10, 2);
                $table->string('descripcion')->nullable();
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('movimientos_stock', 'producto_variedad_id') && Schema::hasTable('producto_variedades')) {
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
        Schema::dropIfExists('movimientos_stock');

        if (Schema::hasTable('producto_variedades')) {
            Schema::table('producto_variedades', function (Blueprint $table) {
                foreach (['stock_actual', 'stock_minimo', 'controla_stock'] as $column) {
                    if (Schema::hasColumn('producto_variedades', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        Schema::table('productos', function (Blueprint $table) {
            foreach (['stock_actual', 'stock_minimo', 'controla_stock'] as $column) {
                if (Schema::hasColumn('productos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
