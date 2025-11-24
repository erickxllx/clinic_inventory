<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        // Total de medicamentos
        $totalProducts = Product::count();

        // Medicamentos con bajo stock
        $lowStockProducts = Product::whereColumn('current_qty', '<=', 'min_stock')
                                    ->orderBy('current_qty', 'asc')
                                    ->take(5)
                                    ->get();

        // Últimos movimientos
        $latestMovements = InventoryMovement::with('product', 'user')
                                            ->latest()
                                            ->take(5)
                                            ->get();

        // Gráfica — últimos 7 días
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = $date;

            $count = InventoryMovement::whereDate('created_at', $date)->count();
            $chartData[] = $count;
        }

        return view('dashboard.index', compact(
            'role',
            'totalProducts',
            'lowStockProducts',
            'latestMovements',
            'chartLabels',
            'chartData'
        ));
    }
}
