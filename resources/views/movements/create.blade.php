@extends('layouts.app')

@section('title', 'Nuevo Movimiento')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">

    <h1 class="text-2xl font-bold mb-4 text-gray-700">Nuevo Movimiento</h1>

    <form action="{{ route('movements.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-600">Medicamento *</label>
            <select name="product_id"
                    class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->current_qty }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Tipo *</label>
            <select name="type"
                    class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
                <option value="ajuste">Ajuste</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Cantidad *</label>
            <input type="number" name="quantity" value="{{ old('quantity', 1) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" min="1" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Fecha *</label>
            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Nota</label>
            <textarea name="note" rows="3"
                      class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">{{ old('note') }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('movements.index') }}"
               class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-700">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
