<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    //
use HasFactory;
    protected $guarded = [];

    // Relación con un usuario en este caso un vendedor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los Detalles de la Venta
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

}
