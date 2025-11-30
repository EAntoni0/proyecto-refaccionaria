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
    Schema::create('sale_details', function (Blueprint $table) {
        $table->id();
        
        // Relaciones
        $table->foreignId('sale_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained();
        
        // Datos históricos (Importante guardar el precio al momento de la venta)
        $table->integer('quantity'); // Cuántas piezas llevó
        $table->decimal('price', 10, 2); // Precio unitario en ese momento
        $table->decimal('subtotal', 10, 2); // quantity * price
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
