<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'torneos' con relación a 'events'.
     */
    public function up(): void
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la tabla de eventos
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            // Información del jugador
            $table->string('competidor');
            $table->integer('puntos')->default(0);
            $table->integer('victorias')->default(0);
            $table->integer('derrotas')->default(0);
            $table->integer('bye')->default(0);
            $table->float('porcentaje1')->default(0);
            $table->float('porcentaje2')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla 'torneos' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('torneos');
    }
};
