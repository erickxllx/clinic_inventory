<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\InventoryMovement;

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
}