@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">

        <h1 class="text-3xl font-bold mb-6 text-gray-700">Bienvenido al Dashboard</h1>

        {{-- Mensaje según rol --}}
        @if ($role === 'admin')
            <p class="text-blue-600 mb-4">Tienes acceso total al sistema.</p>
        @endif
        @if ($role === 'nurse')
            <p class="text-green-600 mb-4">Puedes registrar movimientos del inventario.</p>
        @endif
        @if ($role === 'doctor')
            <p class="text-purple-600 mb-4">Tienes acceso de lectura.</p>
        @endif
        @if ($role === 'assistant')
            <p class="text-gray-600 mb-4">Acceso limitado a consultas.</p>
        @endif

        <div class="max-w-7xl mx-auto px-6 py-8">

            <h1 class="text-3xl font-bold mb-8 text-gray-700">Dashboard</h1>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <!-- Total Productos -->
                <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
                    <h3 class="text-gray-500 text-sm font-medium">Total de Medicamentos</h3>
                    <div class="mt-3 text-4xl font-semibold text-blue-600">{{ $totalProducts }}</div>
                </div>

                <!-- Stock Bajo -->
                <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
                    <h3 class="text-gray-500 text-sm font-medium">Medicamentos con Stock Bajo</h3>
                    <div class="mt-3 text-4xl font-semibold text-red-500">{{ $lowStockProducts->count() }}</div>
                </div>

                <!-- Movimientos -->
                <a href="{{ route('movements.index') }}" class="block">
                    <div
                        class="bg-white shadow-md rounded-xl p-6 border border-gray-100 hover:shadow-lg transition cursor-pointer">
                        <h3 class="text-gray-500 text-sm font-medium">Movimientos Recientes</h3>
                        <div class="mt-3 text-4xl font-semibold text-green-600">{{ $latestMovements->count() }}</div>
                    </div>
                </a>

            </div>


            <!-- Tabla de Stock Bajo -->
            <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100 mb-10">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Medicamentos con Stock Bajo</h2>

                <!-- Buscador + PDF -->
                <div class="flex flex-col sm:flex-row justify-between mb-4 gap-3">
                    <input type="text" onkeyup="searchTable(this, 'tabla_stock_bajo')"
                        placeholder="Buscar medicamento..." class="w-full sm:w-64 px-4 py-2 border rounded-lg shadow-sm">

                    <a href="{{ route('pdf.stock-bajo') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-center">
                        Descargar PDF
                    </a>
                </div>


                <div class="overflow-x-auto">
                    <table id="tabla_stock_bajo" class="w-full text-left text-sm min-w-[600px]">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Nombre</th>
                                <th class="py-2">Stock Actual</th>
                                <th class="py-2">Stock Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStockProducts as $item)
                                <tr class="border-b">
                                    <td class="py-2">{{ $item->name }}</td>
                                    <td class="py-2 text-red-600">{{ $item->current_qty }}</td>
                                    <td class="py-2">{{ $item->min_stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Movimientos recientes -->
            <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100 mb-10">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Últimos Movimientos</h2>

                <!-- Buscador + PDF -->
                <div class="flex flex-col sm:flex-row justify-between mb-4 gap-3">
                    <input type="text" onkeyup="searchTable(this, 'tabla_movimientos')"
                        placeholder="Buscar movimiento..." class="w-full sm:w-64 px-4 py-2 border rounded-lg shadow-sm">

                    <a href="{{ route('pdf.movimientos') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-center">
                        Descargar PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table id="tabla_movimientos" class="w-full text-sm min-w-[600px] table-auto">
                        <thead>
                            <tr class="border-b text-gray-600 text-left">
                                <th class="py-2 px-3 w-28">Tipo</th>
                                <th class="py-2 px-3 w-40">Producto</th>
                                <th class="py-2 px-3 w-24 text-center">Cantidad</th>
                                <th class="py-2 px-3 w-32 text-center">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestMovements as $mv)
                                <tr class="border-b">
                                    <td class="py-2 px-3">{{ $mv->type }}</td>
                                    <td class="py-2 px-3">{{ $mv->product->name }}</td>
                                    <td class="py-2 px-3 text-center">{{ $mv->quantity }}</td>
                                    <td class="py-2 px-3 text-center">
                                        {{ \Carbon\Carbon::parse($mv->date)->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


            <!-- Gráfica -->
            <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100" style="height: 350px;">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Movimientos en los últimos 7 días</h2>
                <canvas id="movChart" class="w-full h-full"></canvas>
            </div>


        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const ctx = document.getElementById('movChart').getContext('2d');

                // 🎨 Gradiente profesional (azul -> transparente)
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
                gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Movimientos',
                            data: @json($chartData),
                            fill: true,
                            backgroundColor: gradient,
                            borderColor: '#2563EB',
                            borderWidth: 3,
                            tension: 0.45,
                            pointBackgroundColor: '#1E40AF',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointHoverBorderWidth: 2,
                            pointHoverBackgroundColor: '#3B82F6',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Quita el texto "Movimientos"
                            },
                            tooltip: {
                                backgroundColor: '#1E293B',
                                titleColor: '#fff',
                                bodyColor: '#CBD5E1',
                                padding: 12,
                                borderWidth: 0,
                                displayColors: false,
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#475569',
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(203, 213, 225, 0.4)'
                                },
                                ticks: {
                                    color: '#475569',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>


    @endsection
