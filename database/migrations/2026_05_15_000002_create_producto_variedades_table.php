<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto_variedades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('orden')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_variedades');
    }
};
