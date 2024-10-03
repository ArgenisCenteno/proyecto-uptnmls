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
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable(); // Fecha de vencimiento
            $table->text('descripcion');
            $table->string('financiamiento');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('creado_por'); // Añade la columna creado_por
            
            // Define la relación
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade'); 
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']); // Elimina la relación con proveedores
            $table->dropForeign(['creado_por']); // Elimina la relación con users
        });

        Schema::dropIfExists('solicitudes');
    }
};
