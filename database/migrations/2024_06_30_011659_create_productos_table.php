<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_compra', 8, 2); // Precio de compra
            $table->decimal('precio_venta', 8, 2);  // Precio de venta
            $table->boolean('aplica_iva')->default(false); // Aplica IVA
            $table->string('lote')->nullable(); // Lote del producto
            $table->date('fecha_vencimiento')->nullable(); // Fecha de vencimiento
            $table->integer('cantidad'); // Cantidad en stock
            $table->unsignedBigInteger('sub_categoria_id');
            $table->foreign('sub_categoria_id')->references('id')->on('sub_categorias')->onDelete('cascade');
            $table->boolean('disponible')->default(true); // Disponible para la venta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
