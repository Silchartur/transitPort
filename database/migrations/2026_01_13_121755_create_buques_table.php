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
        Schema::create('buques', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->text('nombre');
            $table->text('tipo');
            $table->integer('capacidad');
            $table->enum('estado', ['salido', 'en espera', 'atracado'])->default('en espera');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buques');
    }
};
