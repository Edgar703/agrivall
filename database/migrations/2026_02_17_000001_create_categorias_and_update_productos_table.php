<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
        });

        Schema::table('productos', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['variedad', 'formato', 'imagen', 'disponible'] as $column) {
                if (Schema::hasColumn('productos', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            if (!Schema::hasColumn('productos', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }

            if (!Schema::hasColumn('productos', 'categoria_id')) {
                $table->foreignId('categoria_id')
                    ->nullable()
                    ->constrained('categorias')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('productos', 'activo')) {
                $table->boolean('activo')->default(true);
            }

            if (!Schema::hasColumn('productos', 'fecha_creacion')) {
                $table->date('fecha_creacion')->nullable();
            }

            $timestampColumns = [];
            foreach (['created_at', 'updated_at'] as $column) {
                if (Schema::hasColumn('productos', $column)) {
                    $timestampColumns[] = $column;
                }
            }

            if (!empty($timestampColumns)) {
                $table->dropColumn($timestampColumns);
            }
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'categoria_id')) {
                $table->dropForeign(['categoria_id']);
                $table->dropColumn('categoria_id');
            }

            $columnsToDrop = [];
            foreach (['descripcion', 'activo', 'fecha_creacion'] as $column) {
                if (Schema::hasColumn('productos', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            if (!Schema::hasColumn('productos', 'variedad')) {
                $table->string('variedad')->nullable();
            }

            if (!Schema::hasColumn('productos', 'formato')) {
                $table->string('formato')->nullable();
            }

            if (!Schema::hasColumn('productos', 'imagen')) {
                $table->string('imagen')->nullable();
            }

            if (!Schema::hasColumn('productos', 'disponible')) {
                $table->boolean('disponible')->nullable();
            }

            $timestampColumns = [];
            foreach (['created_at', 'updated_at'] as $column) {
                if (!Schema::hasColumn('productos', $column)) {
                    $timestampColumns[] = $column;
                }
            }

            if (!empty($timestampColumns)) {
                $table->timestamps();
            }
        });

        Schema::dropIfExists('categorias');
    }
};
