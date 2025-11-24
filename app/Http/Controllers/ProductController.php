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
            'name'          => 'required|string|max:255',
            'presentation'  => 'nullable|string|max:255',
            'initial_qty'   => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'photo'         => 'nullable|image|max:2048',
        ]);

        // Guardar foto
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

        // current_qty inicia igual que initial_qty
        $data['current_qty'] = $data['initial_qty'];

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
            'name'          => 'required|string|max:255',
            'presentation'  => 'nullable|string|max:255',
            'current_qty'   => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'photo'         => 'nullable|image|max:2048',
        ]);

        // Si suben una nueva foto
        if ($request->hasFile('photo')) {

            // Borrar foto anterior si existe
            if ($product->photo) {
                \Storage::disk('public')->delete($product->photo);
            }

            // Guardar nueva foto
            $data['photo'] = $request->file('photo')->store('products', 'public');
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
