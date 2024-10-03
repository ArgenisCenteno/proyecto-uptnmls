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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->date('fecha'); // Fecha del trámite
            $table->string('tipo'); // Tipo de trámite
            $table->text('descripcion'); // Descripción del trámite
            $table->unsignedBigInteger('personal_id')->nullable(); // ID del usuario asociado
            $table->unsignedBigInteger('creado_por'); // ID del usuario que crea el trámite
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'rechazado']); // Estado del trámite
            $table->timestamps(); // Campos created_at y updated_at

            // Definición de claves foráneas si es necesario
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
