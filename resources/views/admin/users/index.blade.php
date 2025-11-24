<x-app-layout>
    <div class="p-6">

        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Usuarios</h1>
            <a href="{{ route('users.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md">
               + Crear Usuario
            </a>
        </div>

        <table class="w-full bg-white shadow rounded-md">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Rol</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr class="border-b">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3 capitalize">{{ $user->role }}</td>
                        <td class="p-3">
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-blue-600 mr-3">Editar</a>

                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
