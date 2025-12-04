<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_create_products_table.php

public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        
        // Relación con Categoría
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        $table->string('name');
        $table->string('slug')->unique(); // Para URLs amigables (ej: zapatillas-nike)
        $table->text('description')->nullable();
        
        $table->decimal('price', 10, 2); // 10 dígitos total, 2 decimales
        $table->integer('stock')->default(0); // El almacenista lo modificará, pero inicia en 0
        
        // Ruta de la imagen (Ej: products/imagen1.jpg)
        $table->string('image_path')->nullable(); 
        
        $table->enum('status', ['active', 'draft'])->default('active'); // Para ocultar productos sin borrarlos

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
