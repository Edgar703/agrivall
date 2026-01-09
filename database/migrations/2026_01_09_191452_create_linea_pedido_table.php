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
        Schema::create('linea_pedido', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->onDelete('cascade');

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->onDelete('cascade');

            $table->string('formato')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 8, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_pedido');
    }
};
