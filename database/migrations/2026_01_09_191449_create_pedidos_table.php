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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_pedido')->useCurrent();
            $table->string('nombre_cliente');
            $table->string('email_cliente');
            $table->string('tlf_cliente', 15);

            $table->enum('metodo_pago', ['Visa', 'Efectivo', 'Bizzum', 'Transferencia']);

            $table->string('direccion_envio');
            $table->decimal('precio_pedido', 8, 2);

            $table->enum('estado', ['Pendiente', 'Pagado', 'Enviado', 'Cancelado'])->default('Pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
