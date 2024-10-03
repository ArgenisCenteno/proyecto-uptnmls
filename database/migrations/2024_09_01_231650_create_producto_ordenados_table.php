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
        Schema::create('producto_ordenados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->float('cantidad')->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('solicitud_id');

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade'); 
            $table->foreign('solicitud_id')->references('id')->on('solicitud')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto_ordenados', function (Blueprint $table) {
            $table->dropForeign(['producto_id']); // Elimina la relación con proveedores
            $table->dropForeign(['solicitud_id']); // Elimina la relación con users
        });

        Schema::dropIfExists('producto_ordenados');
    }
};
