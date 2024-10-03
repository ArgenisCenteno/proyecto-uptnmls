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
        Schema::create('productos_asignados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->float('cantidad')->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('asignacion_id');

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade'); 
            $table->foreign('asignacion_id')->references('id')->on('asignacions')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_asignados', function (Blueprint $table) {
            $table->dropForeign(['producto_id']); // Elimina la relación con proveedores
            $table->dropForeign(['asignacion_id']); // Elimina la relación con users
        });

        Schema::dropIfExists('productos_asignados');
    }
};
