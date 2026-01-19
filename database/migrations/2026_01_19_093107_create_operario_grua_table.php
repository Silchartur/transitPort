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
        Schema::create('operario_grua', function (Blueprint $table) {
            $table->id();
            $table->string('turno');
            $table->date('fecha');
            $table->timestamps();

            $table->foreignId('operario_id')
                    ->constrained('operarios')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('grua_id')
                    ->constrained('gruas')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('operario_grua');
    }
};
