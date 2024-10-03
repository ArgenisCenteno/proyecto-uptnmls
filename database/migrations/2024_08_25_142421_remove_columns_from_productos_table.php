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
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn([
                'precio_compra',
                'precio_venta',
                'aplica_iva',
                'fecha_vencimiento',
            ]);

            $table->string('unidad_medida')->nullable(); // Puedes ajustar nullable según tus necesidades

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio_compra', 10, 2)->nullable(); 
            $table->decimal('precio_venta', 10, 2)->nullable();  
            $table->boolean('aplica_iva')->nullable();
         
            $table->date('fecha_vencimiento')->nullable();
            $table->dropColumn('unidad_medida');

        });

    }
};
