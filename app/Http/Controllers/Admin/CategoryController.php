<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. LISTAR (Usando DataTable)
    public function index()
    {
        return view('admin.categories.index');
    }

    // 2. MOSTRAR FORMULARIO DE CREAR
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. GUARDAR EN BD
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            // Agrega 'description' si tu tabla lo tiene
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada con éxito.');
    }

    // 4. MOSTRAR FORMULARIO DE EDICIÓN
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. ACTUALIZAR EN BD
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    // 6. ELIMINAR
    public function destroy(Category $category)
    {
        // Opcional: Validar si tiene productos antes de borrar
        if($category->products()->count() > 0){
             return redirect()->route('admin.categories.index')
                ->with('error', 'No puedes borrar una categoría que tiene productos asociados.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría eliminada.');
    }
}