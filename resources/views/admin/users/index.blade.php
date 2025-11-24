@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Usuarios</h1>

    <div class="bg-white shadow rounded-lg p-6">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
            <h3 class="text-lg font-semibold">Lista de Usuarios</h3>

            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                Crear Usuario
            </a>
        </div>

        <!-- CONTENEDOR PARA HACER SCROLL HORIZONTAL EN MÓVIL -->
        <div class="overflow-x-auto">
            <table class="w-full mt-4 border-collapse min-w-[600px]">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Rol</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3 capitalize">{{ $user->role }}</td>
                            <td class="p-3 flex flex-col sm:flex-row sm:space-x-2 gap-2">

                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-center">
                                    Editar
                                </a>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 w-full sm:w-auto">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
