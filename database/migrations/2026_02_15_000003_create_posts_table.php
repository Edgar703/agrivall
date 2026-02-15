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
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();

                $table->foreignId('tipo_post_id')
                    ->nullable()
                    ->constrained('tipo_post')
                    ->onDelete('set null');

                $table->string('titulo')->nullable();
                $table->text('noticia')->nullable();
                $table->text('contenido')->nullable();
                $table->string('categoria', 255)->default('');

                $table->dateTime('fecha_public')->nullable()->useCurrent();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
