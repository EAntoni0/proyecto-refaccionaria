<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        // Enviamos las categorías a la vista para el <select>
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:products',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        // 2. Preparamos los datos
        $data = $request->all();
        //slug para tener un nombre mas accesible para url, sin espacios, caracteres, todo en minuscula
        $data['slug'] = Str::slug($request->name);

        // 3. Manejo de la Imagen
        if ($request->hasFile('image')) {
            // Guarda en storage/app/public/products y devuelve la ruta
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        // 4. Crear Producto
        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    // 4. MOSTRAR FORMULARIO DE EDICIÓN
    public function edit(Product $product)
    {
        // Necesitamos las categorías para llenar el select
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. ACTUALIZAR PRODUCTO
    public function update(Request $request, Product $product)
    {



        $request->validate([
            'category_id' => 'required|exists:categories,id',
            // Validamos que el nombre sea único, PERO ignoramos el ID del producto actual
            'name' => 'required|unique:products,name,' . $product->id, 
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        // Si suben una IMAGEN NUEVA
        if ($request->hasFile('image')) {
            // 1. Borramos la imagen vieja si existe
            if ($product->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            // 2. Guardamos la nueva
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
        
    }


    //ELIMINAR PRODUCTO 
    public function destroy(Product $product)
    {
        //eliminar imagen del servidor
        if ($product->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado.');
    }

}