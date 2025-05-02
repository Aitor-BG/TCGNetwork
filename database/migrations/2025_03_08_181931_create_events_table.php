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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            /*$table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();*/
            $table->date('date')->nullable();
            $table->string('color')->nullable();
            $table->text('details')->nullable();
            $table->text('inscritos')->nullable();
            $table->integer('participantes')->nullable();
            $table->boolean('en_curso')->default(false);
            /*$table->enum('estado', ['revision', 'verificado'])->default('revision');*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
