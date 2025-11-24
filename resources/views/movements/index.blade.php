@extends('layouts.app')

@section('title', 'Movimientos')

@section('content')
<div class="max-w-6xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Movimientos</h1>

        @if(in_array(auth()->user()->role, ['admin','nurse']))
            <a href="{{ route('admin.movements.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                + Nuevo Movimiento
            </a>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left text-gray-500 text-xs uppercase">
                    <th class="py-2">Fecha</th>
                    <th class="py-2">Tipo</th>
                    <th class="py-2">Producto</th>
                    <th class="py-2">Cantidad</th>
                    <th class="py-2">Antes</th>
                    <th class="py-2">Después</th>
                    <th class="py-2">Registrado por</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $mv)
                    <tr class="border-b">
                        <td class="py-2">{{ $mv->date }}</td>
                        <td class="py-2 capitalize">
                            @if($mv->type === 'entrada')
                                <span class="text-green-600 font-semibold">Entrada</span>
                            @elseif($mv->type === 'salida')
                                <span class="text-red-600 font-semibold">Salida</span>
                            @else
                                <span class="text-yellow-600 font-semibold">Ajuste</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $mv->product->name }}</td>
                        <td class="py-2">{{ $mv->quantity }}</td>
                        <td class="py-2">{{ $mv->previous_qty }}</td>
                        <td class="py-2">{{ $mv->new_qty }}</td>
                        <td class="py-2">{{ $mv->user->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">
                            No hay movimientos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
