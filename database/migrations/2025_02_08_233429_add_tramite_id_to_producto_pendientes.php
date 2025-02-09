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
        Schema::table('producto_pendientes', function (Blueprint $table) {
            $table->foreignId('tramite_id')->nullable()->constrained('tramites')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::table('producto_pendientes', function (Blueprint $table) {
            $table->dropForeign(['tramite_id']);
            $table->dropColumn('tramite_id');
        });
    }
};
