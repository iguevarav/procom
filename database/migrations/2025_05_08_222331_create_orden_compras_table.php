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
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->string('numero_documento')->unique(); 
            $table->date('fecha_compra');
            $table->string('motivo_compra');
            $table->decimal('subtotal', 10, 2);
            $table->enum('estado', ['PENDIENTE', 'COMPLETADA', 'CANCELADA']);
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
        });        
        
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_compras');
    }
};
