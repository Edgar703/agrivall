<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('linea_pedido', function (Blueprint $table) {
            $table->foreignId('producto_variedad_id')->nullable()->after('producto_id')->constrained('producto_variedades')->nullOnDelete();
            $table->string('nombre_producto')->nullable()->after('producto_variedad_id');
            $table->string('nombre_variedad')->nullable()->after('nombre_producto');
            $table->string('tipo_venta', 20)->default('unidad')->after('nombre_variedad');
            $table->string('unidad_medida', 10)->default('ud')->after('tipo_venta');
            $table->decimal('subtotal', 10, 2)->default(0)->after('precio_unitario');
        });

        DB::statement('ALTER TABLE linea_pedido MODIFY cantidad DECIMAL(8,2) NULL');

        DB::table('linea_pedido')
            ->join('productos', 'productos.id', '=', 'linea_pedido.producto_id')
            ->update([
                'linea_pedido.nombre_producto' => DB::raw('productos.nombre'),
                'linea_pedido.tipo_venta' => 'unidad',
                'linea_pedido.unidad_medida' => 'ud',
                'linea_pedido.subtotal' => DB::raw('ROUND(COALESCE(linea_pedido.cantidad, 0) * COALESCE(linea_pedido.precio_unitario, 0), 2)'),
            ]);
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE linea_pedido MODIFY cantidad INT NULL');

        Schema::table('linea_pedido', function (Blueprint $table) {
            $table->dropConstrainedForeignId('producto_variedad_id');
            $table->dropColumn([
                'nombre_producto',
                'nombre_variedad',
                'tipo_venta',
                'unidad_medida',
                'subtotal',
            ]);
        });
    }
};
