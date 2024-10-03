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
        Schema::table('asignacions', function (Blueprint $table) {
            $table->string('status', 50)->nullable(); // Agrega la columna 'status'
            $table->unsignedBigInteger('requerimiento_id'); // Añade la columna 'requerimiento_id'
            $table->unsignedBigInteger('tramite_id'); // Añade la columna 'requerimiento_id'
            // Define la relación
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos')->onDelete('cascade'); 
            $table->foreign('tramite_id')->references('id')->on('tramites')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignacions', function (Blueprint $table) {
            // Primero elimina la clave foránea si existe
            $table->dropForeign(['requerimiento_id']);
            // Luego elimina la columna
            $table->dropColumn('requerimiento_id');

            // Primero elimina la clave foránea si existe
            $table->dropForeign(['tramite_id']);
            // Luego elimina la columna
            $table->dropColumn('tramite_id');
            $table->dropColumn('status');
        });
    }
};
