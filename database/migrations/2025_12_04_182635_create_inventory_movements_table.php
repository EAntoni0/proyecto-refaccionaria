<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crea la tabla 'inventory_movements'
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            
            // Relaciones (Foreign Keys)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); 
            
            // Datos del movimiento
            $table->enum('type', ['entrada', 'salida', 'ajuste']); 
            $table->integer('quantity'); 
            
            // NOTA: No incluimos 'notes' porque decidiste borrarlo.
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};