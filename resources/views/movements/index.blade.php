@extends('layouts.app')

@section('title', 'Movimientos')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg shadow border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- HEADER: Título y Botones --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Movimientos</h1>

            <div class="flex flex-wrap gap-2">
                <button onclick="openFilters()"
                    class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition shadow-sm w-full sm:w-auto">
                    Filtros
                </button>

                <button onclick="exportPDF()"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 shadow w-full sm:w-auto">
                    Descargar PDF
                </button>

                @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'nurse']))
                    <a href="{{ route('movements.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 shadow w-full sm:w-auto text-center">
                        + Nuevo Movimiento
                    </a>
                @endif
            </div>
        </div>

        {{-- CONTENEDOR PRINCIPAL (Solo Tabla, sin duplicados) --}}
        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">

            <div class="overflow-x-auto">
                <table id="movementsTable" class="w-full text-sm min-w-[800px]">
                    <thead>
                        <tr class="border-b text-left text-gray-500 text-xs uppercase bg-gray-50">
                            <th class="py-3 px-2">Fecha</th>
                            <th class="py-3 px-2">Tipo</th>
                            <th class="py-3 px-2">Producto</th>
                            <th class="py-3 px-2 text-center">Cant.</th>
                            <th class="py-3 px-2 text-center">Antes</th>
                            <th class="py-3 px-2 text-center">Después</th>
                            <th class="py-3 px-2">Paciente</th>
                            <th class="py-3 px-2">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $mv)
                            {{-- Detectamos el tipo para usarlo en filtros y lógica --}}
                            @php
                                $type = strtolower($mv->type);
                            @endphp

                            <tr class="border-b hover:bg-gray-50 movement-item transition"
                                data-date="{{ substr($mv->date, 0, 10) }}" data-type="{{ $type }}"
                                data-user="{{ strtolower($mv->user->name ?? '') }}"
                                data-search="{{ strtolower(($mv->product->name ?? '') . ' ' . ($mv->note ?? '') . ' ' . ($mv->user->name ?? '')) }}">

                                <td class="py-3 px-2 text-gray-600">{{ $mv->date }}</td>

                                <td class="py-2 capitalize">
                                    @if ($mv->type === 'entrada')
                                        <span class="text-green-600 font-semibold">Entrada</span>
                                    @elseif($mv->type === 'salida')
                                        <span class="text-red-600 font-semibold">Salida</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">Ajuste</span>
                                    @endif
                                </td>

                                <td class="py-3 px-2 font-medium text-gray-800">
                                    {{ $mv->product->name ?? 'Producto Eliminado' }}</td>
                                <td class="py-3 px-2 text-center font-bold">{{ $mv->quantity }}</td>
                                <td class="py-3 px-2 text-center text-gray-500">{{ $mv->previous_qty }}</td>
                                <td class="py-3 px-2 text-center text-gray-500">{{ $mv->new_qty }}</td>
                                <td class="py-3 px-2 text-gray-600 truncate max-w-xs" title="{{ $mv->note }}">
                                    {{ $mv->note }}</td>
                                <td class="py-3 px-2 text-gray-500 text-xs">{{ $mv->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-500">
                                    No hay movimientos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-6">
                {{ $movements->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL DE FILTROS --}}
    <div id="filtersModal"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity">
        <div class="bg-white w-11/12 sm:w-[420px] rounded-xl shadow-xl p-6 animate-fadeIn">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">Filtrar Movimientos</h2>
                <button onclick="closeFilters()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Buscar</label>
                    <input type="text" id="searchInput" placeholder="Producto, usuario, paciente..."
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Desde</label>
                        <input type="date" id="dateFrom"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Hasta</label>
                        <input type="date" id="dateTo"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Tipo</label>
                    <select id="typeFilter" class="w-full px-3 py-2 rounded-lg border border-gray-300 shadow-sm bg-white">
                        <option value="">Todos</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                        <option value="ajuste">Ajuste</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Registrado por</label>
                    <input type="text" id="userFilter" placeholder="Nombre del usuario"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeFilters()"
                    class="px-4 py-2 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200 transition font-medium">
                    Cerrar
                </button>
                <button onclick="applyFilters()"
                    class="px-4 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-700 transition shadow font-medium">
                    Aplicar Filtros
                </button>
            </div>
        </div>
    </div>

    {{-- ESTILOS DE ANIMACIÓN --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn .2s ease-out;
        }
    </style>

    {{-- SCRIPTS --}}
    <script>
        function openFilters() {
            document.getElementById("filtersModal").classList.remove("hidden");
        }

        function closeFilters() {
            document.getElementById("filtersModal").classList.add("hidden");
        }

        function applyFilters() {
            filterMovements();
            closeFilters();
        }

        function filterMovements() {
            let search = document.getElementById("searchInput").value.toLowerCase();
            let from = document.getElementById("dateFrom").value;
            let to = document.getElementById("dateTo").value;
            let type = document.getElementById("typeFilter").value;
            let user = document.getElementById("userFilter").value.toLowerCase();

            let items = document.querySelectorAll(".movement-item");

            items.forEach(item => {
                let itemDate = item.dataset.date;
                let itemType = item.dataset.type; // Esto vendrá como 'in', 'out', 'entrada', etc.
                let itemUser = item.dataset.user;
                let itemSearchData = item.dataset.search;

                let show = true;

                if (search && !itemSearchData.includes(search)) show = false;

                // Filtro de tipo: hacemos la coincidencia flexible
                if (type) {
                    if (type === 'entrada' && !itemType.includes('in') && !itemType.includes('entrada')) show =
                        false;
                    if (type === 'salida' && !itemType.includes('out') && !itemType.includes('salida')) show =
                    false;
                    if (type === 'ajuste' && !itemType.includes('adj') && !itemType.includes('ajuste')) show =
                    false;
                }

                if (user && !itemUser.includes(user)) show = false;
                if (from && itemDate < from) show = false;
                if (to && itemDate > to) show = false;

                item.style.display = show ? "" : "none";
            });
        }

        function exportPDF() {
            const params = new URLSearchParams({
                search: document.getElementById("searchInput").value,
                from: document.getElementById("dateFrom").value,
                to: document.getElementById("dateTo").value,
                type: document.getElementById("typeFilter").value,
                user: document.getElementById("userFilter").value,
            });

            window.location.href = "{{ route('pdf.movimientos') }}?" + params.toString();
        }
    </script>
@endsection
