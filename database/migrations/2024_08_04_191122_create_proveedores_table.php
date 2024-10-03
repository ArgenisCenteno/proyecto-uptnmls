<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); // Campo id auto incrementable
            $table->string('razon_social'); // Razón social del proveedor
            $table->string('telefono'); // Teléfono del proveedor
            $table->string('email')->unique(); // Email del proveedor
            $table->string('estado'); // Estado del proveedor
            $table->string('municipio'); // Municipio del proveedor
            $table->string('parroquia'); // Parroquia del proveedor
            $table->string('rif')->unique(); // RIF del proveedor
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
