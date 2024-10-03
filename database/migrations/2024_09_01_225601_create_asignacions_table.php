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
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable(); // Fecha de vencimiento
            $table->text('descripcion');

            $table->unsignedBigInteger('personal_id');
            $table->unsignedBigInteger('creado_por'); // Añade la columna creado_por
            // Define la relación
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade'); 
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacions');
    }
};
