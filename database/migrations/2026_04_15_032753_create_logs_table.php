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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_id');
            $table->string('tipo'); //"comando", "alerta","Administrador", "Sistema", etc.
            $table->string('icono'); // fa-fan, fa-tint, fa-bell, etc.
            $table->string('mensaje');
            $table->string('nivel')->default('info'); // info, advertencia, error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
