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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');

            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');


            $table->unsignedBigInteger('id_marca');
            $table->foreign('id_marca')->references('id')->on('marcas')->onDelete('cascade');

            $table->decimal('costo', 8,2);
            $table->decimal('precio', 8, 2);
            $table->integer('stock');

            $table->unsignedBigInteger('id_unidad');
            $table->foreign('id_unidad')->references('id')->on('unidades')->onDelete('cascade');

            $table->enum('estado', ['ACTIVO', 'ANULADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
