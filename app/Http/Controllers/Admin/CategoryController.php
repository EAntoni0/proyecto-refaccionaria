<?php

//controlador para las acciones del administrador sobre las categorias


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //listar las categorias
    public function index()
    {
        return view('admin.categories.index');
    }

    //funcion para abrir la vista de de nueva categoria
    public function create()
    {
        return view('admin.categories.create');
    }

    //funcion que guarda en la DB todo lo del formulario de la  vista de categories.create
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada con éxito.');
    }

    //para manejar la ventanna de edicion de una categoria
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // funcion para actualizar 
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