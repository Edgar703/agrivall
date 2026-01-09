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
        Schema::create('postsblog', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tipo_post_id')
                ->constrained('tipo_post')
                ->onDelete('restrict');

            $table->string('titulo')->nullable();
            $table->text('noticia')->nullable();
            $table->string('imagen')->nullable();

            $table->dateTime('fecha_public')->nullable()->useCurrent();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postsblog');
    }
};
