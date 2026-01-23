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
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->boolean('disponible')->default(true);
            $table->boolean('activa')->default(true);
            $table->foreignId('zona_id')->constrained('zonas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            /*
            en el modelo de Zona poner:
                public function parkings() {
                    return $this->hasMany(Parking::class);
                }

            y en el controlador esto:

                $zona->update(['activa'=>false]);
                $zona->parkings()->update(['activa'=>false]);
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
