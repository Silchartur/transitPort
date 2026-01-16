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
        Schema::create('gruas_sts', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->foreignId('id_zona')
                  ->constrained('zonas')
                  ->restrictOnDelete();

            $table->primary('id');

            $table->foreign('id')
                  ->references('id')
                  ->on('gruas')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gruas_sts');
    }
};
