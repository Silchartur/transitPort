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
        Schema::create('ordenesDeTrabajo', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['carga', 'descarga']);
            $table->enum('estado', ['pendiente', 'en curso', 'completada'])->default('pendiente');
            $table->enum('prioridad', ['alta', 'media', 'baja']);
            $table->foreignId('origen')->constrained('buques')->cascadeOnDelete();
            $table->foreignId('destino')->constrained('zonas')->cascadeOnDelete();
            $table->foreignId('contenedor_id')->constrained('contenedores')->cascadeOnDelete();
            $table->foreignId('administrativo_id')->constrained('administrativos')->cascadeOnDelete();
            $table->timestamps();
            $table->text('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenesDeTrabajo');
    }
};
