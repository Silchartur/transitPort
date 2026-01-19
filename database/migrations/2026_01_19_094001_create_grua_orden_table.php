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
        Schema::create('grua_orden', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->foreignId('grua_id')
                    ->constrained('gruas')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('orden_id')
                    ->constrained('ordenesDeTrabajo')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

        });
    }


    /*
     $table->id();
            $table->string('turno');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('operario_id')
                    ->constrained('operarios')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('grua_id')
                    ->constrained('gruas')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
        }); */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grua_orden');
    }
};
