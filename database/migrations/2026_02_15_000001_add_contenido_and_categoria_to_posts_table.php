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
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'contenido')) {
                $table->text('contenido')->nullable();
            }

            if (!Schema::hasColumn('posts', 'categoria')) {
                $table->string('categoria', 255)->default('');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'contenido')) {
                $table->dropColumn('contenido');
            }

            if (Schema::hasColumn('posts', 'categoria')) {
                $table->dropColumn('categoria');
            }
        });
    }
};
