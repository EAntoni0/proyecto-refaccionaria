<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    //estamos diciendo que una categoria puede tener muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
