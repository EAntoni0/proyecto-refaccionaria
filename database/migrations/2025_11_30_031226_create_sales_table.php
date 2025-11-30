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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        
        // ¿Quién hizo la venta? (El vendedor logueado)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Datos generales
        $table->string('customer_name')->nullable(); // Nombre del cliente (opcional)
        $table->decimal('total', 10, 2); // Total a pagar (Ej: 500.00)
        $table->string('status')->default('completed'); // completed, cancelled
        
        $table->timestamps(); // Guarda fecha y hora automáticamente
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
