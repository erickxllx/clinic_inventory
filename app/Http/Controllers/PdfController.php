<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;


class PdfController extends Controller
{
    public function stockBajo()
    {
        $items = Product::whereColumn('current_qty', '<=', 'min_stock')->get();

        $pdf = Pdf::loadView('pdf.stock_bajo', compact('items'));
        return $pdf->download('Stock_Bajo.pdf');
    }

    public function movimientos()
    {
        $moves = InventoryMovement::latest()->take(50)->get();

        $pdf = Pdf::loadView('pdf.movimientos', compact('moves'));
        return $pdf->download('Movimientos.pdf');
    }

    public function medicamentos()
    {
        $medicamentos = Product::all();
        $fecha = now()->format('d/m/Y h:i A');

        $pdf = Pdf::loadView('pdf.medicamentos', compact('medicamentos', 'fecha'));

        return $pdf->download('reporte_medicamentos.pdf');
    }
   
    public function movimientosFiltrados(Request $request)
    {
        // Recogemos los filtros
        $search = $request->input('search');
        $from   = $request->input('from');
        $to     = $request->input('to');
        $type   = $request->input('type');
        $user   = $request->input('user');

        // Aplicamos la misma consulta (Query) que en la vista web
        $query = InventoryMovement::with(['product', 'user'])->orderBy('date', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhere('note', 'like', "%{$search}%")
                ->orWhereHas('user', function($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($from) {
            $query->whereDate('date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('date', '<=', $to);
        }

        if ($type) {
            $query->where('type', $type);
        }
        
        // Filtro por usuario (si lo usas)
        if ($user) {
             $query->whereHas('user', function($q) use ($user) {
                $q->where('name', 'like', "%{$user}%");
            });
        }

        $movements = $query->get(); // Usamos get() para PDF, no paginate()

        $pdf = PDF::loadView('pdf.movimientos', compact('movements'));
        
        // Orientación horizontal para que quepa la tabla
        $pdf->setPaper('a4', 'landscape'); 

        return $pdf->download('reporte-movimientos.pdf');
    }
}

