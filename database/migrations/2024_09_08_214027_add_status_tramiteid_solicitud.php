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
            $table->string('status');
            $table->unsignedBigInteger('tramite_id'); // Añade la columna creado_por
            $table->timestamps();
            // Define la relación
            $table->foreign('tramite_id')->references('id')->on('tramites')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropForeign(['tramite_id']); // Elimina la relación con users
        });

        Schema::dropIfExists('tramite_id');
        Schema::dropIfExists('status');
    }
};
