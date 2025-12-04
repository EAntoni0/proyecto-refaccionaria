<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos que permitimos guardar
    protected $fillable = [
        'category_id', 
        'name', 
        'slug', 
        'description', 
        'price', 
        'stock', 
        'image_path',
        'status'
    ];

    // Relación: Un producto PERTENECE a una Categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // Opcional: Relación con los movimientos de inventario (Almacenista)
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}