@extends('layouts.app')

@section('title', 'Nuevo Medicamento')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">

    <h1 class="text-2xl font-bold mb-4 text-gray-700">Nuevo Medicamento</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-600">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Presentación</label>
            <input type="text" name="presentation" value="{{ old('presentation') }}"
                   class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">Stock inicial *</label>
                <input type="number" name="initial_qty" value="{{ old('initial_qty', 0) }}"
                       class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Stock mínimo *</label>
                <input type="number" name="min_stock" value="{{ old('min_stock', 0) }}"
                       class="mt-1 w-full border rounded-lg px-3 py-2 text-sm" min="0" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Foto</label>
            <input type="file" name="photo"
                   class="mt-1 w-full text-sm">
            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('products.index') }}"
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
