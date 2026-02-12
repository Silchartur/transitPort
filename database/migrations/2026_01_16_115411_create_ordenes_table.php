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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['carga', 'descarga']);
            $table->enum('estado', ['pendiente', 'en_proceso_sts', 'en_zona_desc', 'en_proceso_sc', 'completada'])->default('pendiente');
            $table->enum('prioridad', ['alta', 'media', 'baja']);
            $table->foreignId('buque_id')->nullable()->constrained('buques');
            $table->foreignId('parking_id')->nullable()->constrained('paarkings');
            $table->foreignId('contenedor_id')->constrained('contenedores')->cascadeOnDelete();
            $table->foreignId('administrativo_id')->constrained('administrativos')->cascadeOnDelete();
            $table->text('observaciones')->nullable();
            $table->timestamps();
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
