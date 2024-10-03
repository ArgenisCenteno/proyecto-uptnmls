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
        Schema::table('solicitud', function (Blueprint $table) {
            $table->unsignedBigInteger('requerimiento_id'); // Añade la columna creado_por
            
            // Define la relación
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropForeign(['requerimiento_id']); // Elimina la relación con users
        });

        Schema::dropIfExists('requerimiento_id');
    }
};
