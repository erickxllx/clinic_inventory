<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de medicamentos
        $totalProducts = Product::count();

        // Medicamentos con bajo stock (current_qty <= min_stock)
        $lowStockProducts = Product::whereColumn('current_qty', '<=', 'min_stock')
                                    ->orderBy('current_qty', 'asc')
                                    ->take(5)
                                    ->get();

        // Últimos movimientos (entradas/salidas/ajustes)
        $latestMovements = InventoryMovement::with('product', 'user')
                                            ->latest()
                                            ->take(5)
                                            ->get();

        // Datos para gráfica (últimos 7 días)
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = $date;

            $count = InventoryMovement::whereDate('date', $date)->count();
            $chartData[] = $count;
        }

        return view('dashboard.index', compact(
            'totalProducts',
            'lowStockProducts',
            'latestMovements',
            'chartLabels',
            'chartData'
        ));
    }
}
