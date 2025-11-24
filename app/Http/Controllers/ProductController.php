<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Mostrar listado de medicamentos
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(15);

        return view('products.index', compact('products'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar nuevo medicamento
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Medicamento creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar medicamento
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // borrar imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Medicamento actualizado correctamente.');
    }

    /**
     * Eliminar medicamento
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Medicamento eliminado.');
    }
}
