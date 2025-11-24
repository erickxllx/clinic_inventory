@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Medicamentos</h1>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                + Nuevo Medicamento
            </a>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
        <table class="w-full text-sm">
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
                    <tr class="border-b">
                        <td class="py-2">
                            @if($product->photo)
                                <img src="{{ asset('storage/'.$product->photo) }}"
                                     class="w-12 h-12 object-cover rounded-md border">
                            @else
                                <span class="text-gray-400 text-xs">Sin foto</span>
                            @endif
                        </td>
                        <td class="py-2 font-medium">{{ $product->name }}</td>
                        <td class="py-2">{{ $product->presentation }}</td>
                        <td class="py-2 {{ $product->current_qty <= $product->min_stock ? 'text-red-600 font-semibold' : '' }}">
                            {{ $product->current_qty }}
                        </td>
                        <td class="py-2">{{ $product->min_stock }}</td>
                        <td class="py-2 text-right space-x-2">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('products.edit', $product) }}"
                                   class="text-blue-600 hover:underline text-sm">Editar</a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este medicamento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
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

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
