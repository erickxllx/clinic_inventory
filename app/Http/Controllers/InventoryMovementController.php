<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{

    public function index()
    {
        $movements = InventoryMovement::with('product', 'user')
                    ->latest()
                    ->paginate(20);

        return view('movements.index', compact('movements'));
    }

    public function create()
    {

        $products = Product::orderBy('name')->get();

        return view('movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:entrada,salida,ajuste',
            'quantity'   => 'required|integer|min:1',
            'date'       => 'required|date',
            'note'       => 'nullable|string',
        ]);

        $product   = Product::findOrFail($data['product_id']);
        $previous  = $product->current_qty;

        if ($data['type'] === 'entrada') {
            $new = $previous + $data['quantity'];
        } elseif ($data['type'] === 'salida') {
            $new = max(0, $previous - $data['quantity']);
        } else { // ajuste: fijar exactamente el stock con "quantity"
            $new = $data['quantity'];
        }

        InventoryMovement::create([
            'product_id'   => $product->id,
            'user_id'      => auth()->id(),
            'type'         => $data['type'],
            'quantity'     => $data['quantity'],
            'previous_qty' => $previous,
            'new_qty'      => $new,
            'date'         => $data['date'],
            'note'         => $data['note'] ?? null,
        ]);

        $product->current_qty = $new;
        $product->save();

        return redirect()->route('movements.index')->with('success', 'Movimiento registrado correctamente.');
    }
}
