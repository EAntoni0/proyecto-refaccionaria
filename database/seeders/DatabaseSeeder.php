<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //para el usuario admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        //para el usuario almacenista
        User::factory()->create([
            'name' => 'Almacenista Erick',
            'email' => 'almacenista1@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'almacenista',
        ]);


        //para el usuario vendedor
        User::factory()->create([
            'name' => 'Vendedor Antonio',
            'email' => 'vendedor1@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'vendedor',
        ]); 

        //con esta linea se crean 5 categorias ademas de 10 productos
        Category::factory(5)->hasProducts(10)->create();
    }
}
