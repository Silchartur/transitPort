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
        Schema::create('grua_contenedor', function (Blueprint $table) {
            $table->id();
            //relaciones con grua y contenedor
            $table->foreignId('grua_id')
                  ->constrained('gruas')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('contenedor_id')
                  ->constrained('contenedores')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grua_contenedor');
    }
};
