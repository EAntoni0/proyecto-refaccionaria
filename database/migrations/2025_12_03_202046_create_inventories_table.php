<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('inventory', function (Blueprint $table) {
        $table->id();
        // Qué producto se movió
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        // Quién lo movió (El almacenista)
        $table->foreignId('user_id')->constrained(); 
        
        // Tipo: 'entrada' (compra a proveedor), 'salida' (merma/ajuste), 'correccion'
        $table->enum('type', ['entrada', 'salida', 'ajuste']); 
        $table->integer('quantity'); // Cuántos entraron o salieron
        $table->text('notes')->nullable(); // Ej: "Llegó pedido del proveedor X"
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
