<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * El calendario de reservas ya trabaja por rangos de fechas.
     * Quitamos la antigua relación con semanas/casillas.
     */
    public function up(): void
    {
        if (Schema::hasTable('reservas') && Schema::hasColumn('reservas', 'semana_casilla_id')) {
            try {
                Schema::table('reservas', function (Blueprint $table) {
                    $table->dropForeign(['semana_casilla_id']);
                });
            } catch (Throwable $e) {
                // Puede no existir la FK en entornos locales antiguos.
            }

            Schema::table('reservas', function (Blueprint $table) {
                $table->dropColumn('semana_casilla_id');
            });
        }

        if (Schema::hasTable('semanascasilla')) {
            Schema::drop('semanascasilla');
        }
    }

    /**
     * Restauración mínima por si hubiera que revertir la limpieza.
     */
    public function down(): void
    {
        if (! Schema::hasTable('semanascasilla')) {
            Schema::create('semanascasilla', function (Blueprint $table) {
                $table->id();
                $table->smallInteger('anio');
                $table->tinyInteger('numero_sem');
                $table->string('descriptor');
                $table->decimal('precio', 10, 2);
                $table->enum('estado', ['libre', 'reservado']);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('reservas') && ! Schema::hasColumn('reservas', 'semana_casilla_id')) {
            Schema::table('reservas', function (Blueprint $table) {
                $table->foreignId('semana_casilla_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('semanascasilla')
                    ->onDelete('restrict');
            });
        }
    }
};
