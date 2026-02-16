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
        Schema::create('contenedores', function (Blueprint $table) {
            $table->id();
            $table->string('num_serie');
            $table->string('companyia');
            $table->boolean('existe');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->enum('ubicacion',['Buque', 'Patio', 'Zona de descarga', 'Parking'])->default('Buque');
            $table->foreignId('buque_id')->constrained('buques');
            $table->foreignId('parking_id')->nullable()->constrained('parkings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenedores');
    }
};
