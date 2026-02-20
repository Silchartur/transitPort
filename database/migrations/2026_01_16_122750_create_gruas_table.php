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
        Schema::create('gruas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['sts', 'sc']);
            $table->enum('estado', ['disponible', 'ocupada']);
            $table->text('observaciones')->nullable();
            $table->foreignId('id_gestor')->onDelete('set null');

            $table->foreignId('id_zona')->constrained('zonas')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gruas');
    }
};
