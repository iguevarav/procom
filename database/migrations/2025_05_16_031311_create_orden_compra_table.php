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
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->id();
            $table->string('numero_documento')->unique();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->date('fecha_compra');
            $table->string('motivo_compra');
            $table->decimal('subtotal', 10, 2);
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_compra');
    }
};
