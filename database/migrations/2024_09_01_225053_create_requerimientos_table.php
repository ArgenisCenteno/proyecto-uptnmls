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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->text('descripcion');
            $table->text('uso');
            $table->unsignedBigInteger('creado_por'); // Añade la columna creado_por
            // Define la relación con la tabla users
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requerimientos', function (Blueprint $table) {
            $table->dropForeign(['creado_por']); // Elimina la relación
        });

        Schema::dropIfExists('requerimientos');
    }
};
