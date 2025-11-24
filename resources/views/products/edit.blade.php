@extends('layouts.app')

@section('title', 'Editar Medicamento')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">

    <h1 class="text-2xl font-bold mb-4 text-gray-700">Editar Medicamento</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-600">Nombre *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Presentación</label>
            <input type="text" name="presentation" value="{{ old('presentation', $product->presentation) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Stock Actual *</label>
            <input type="number" name="current_qty" value="{{ old('current_qty', $product->current_qty) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" min="0" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Stock mínimo *</label>
            <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" min="0" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Foto actual</label>
            @if($product->photo)
                <img src="{{ asset('storage/'.$product->photo) }}" class="w-20 h-20 object-cover rounded-md border mb-2">
            @else
                <p class="text-gray-400 text-xs mb-2">Sin foto</p>
            @endif

            <input type="file" name="photo" class="w-full text-sm">
            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('products.index') }}"
                class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-700">
                    Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
