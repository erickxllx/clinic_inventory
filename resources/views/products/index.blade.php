@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between gap-3 items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Medicamentos</h1>

        <div class="flex gap-3">

            <!-- PDF Button -->
            <a href="{{ route('pdf.medicamentos') }}"
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 shadow">
                Descargar PDF
            </a>

            <!-- Crear -->
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.products.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 shadow">
                    + Nuevo Medicamento
                </a>
            @endif
        </div>
    </div>

    <!-- Buscador -->
    <div class="relative mb-4 w-full sm:w-80">
        <input type="text"
            onkeyup="searchTable(this, 'products_table')"
            placeholder="Buscar medicamento..."
            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">

        <!-- Icono -->
        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.65 3a7.5 7.5 0 006 12.65z"/>
        </svg>
    </div>

    <!-- Tabla -->
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
        <div class="overflow-x-auto">

        <table id="products_table" class="w-full text-sm min-w-[700px]">
            <thead>
                <tr class="border-b text-left text-gray-500 text-xs uppercase">
                    <th class="py-2">Foto</th>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Presentación</th>
                    <th class="py-2">Stock Actual</th>
                    <th class="py-2">Stock Mínimo</th>
                    <th class="py-2 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2">
                            @if($product->photo)
                                <img src="{{ asset('storage/'.$product->photo) }}"
                                     class="w-12 h-12 object-cover rounded-md border shadow-sm">
                            @else
                                <span class="text-gray-400 text-xs">Sin foto</span>
                            @endif
                        </td>

                        <td class="py-2 font-medium text-gray-700">{{ $product->name }}</td>

                        <td class="py-2">{{ $product->presentation }}</td>

                        <td class="py-2 {{ $product->current_qty <= $product->min_stock ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                            {{ $product->current_qty }}
                        </td>

                        <td class="py-2">{{ $product->min_stock }}</td>

                        <td class="py-2 text-right space-x-2">

                            <!-- Editar (amarillo profesional) -->
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="inline-block px-3 py-1 text-sm font-semibold bg-yellow-400 text-gray-900 rounded hover:bg-yellow-500 shadow">
                                Editar
                            </a>

                            <!-- Eliminar (rojo profesional) -->
                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar este medicamento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-block px-3 py-1 text-sm font-semibold bg-red-600 text-white rounded hover:bg-red-700 shadow">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No hay medicamentos registrados.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

<script>
function searchTable(input, tableId) {
    let filter = input.value.toLowerCase();
    let rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}
</script>

@endsection
