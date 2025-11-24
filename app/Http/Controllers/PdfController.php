<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\Movement;

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
        $moves = Movement::latest()->take(50)->get();

        $pdf = Pdf::loadView('pdf.movimientos', compact('moves'));
        return $pdf->download('Movimientos.pdf');
    }
}
