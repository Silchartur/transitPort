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
        Schema::create('operarios', function (Blueprint $table) {
            $table->id();
            $table->text('tipo');
            $table->text('nombre');
            $table->text('apellidos');
            $table->text('email');
            $table->text('contrasenya');
            $table->integer('telefono');
            $table->text('imagen');
            $table->text('observaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operarios');
    }
};
