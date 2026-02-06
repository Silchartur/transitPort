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
        Schema::create('operario_orden', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            //relaciones con operario y orden de trabajo
            $table->foreignId('operario_id')
                  ->constrained('operarios')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('orden_id')
                  ->constrained('ordenes')
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
        Schema::dropIfExists('operario_orden');
    }
};
