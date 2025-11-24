<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">Crear Usuario</h1>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <label class="block mb-2">Nombre</label>
            <input name="name" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Email</label>
            <input name="email" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Contraseña</label>
            <input type="password" name="password" class="w-full p-2 border rounded mb-4">

            <label class="block mb-2">Rol</label>
            <select name="role" class="w-full p-2 border rounded mb-4">
                <option value="admin">Admin</option>
                <option value="nurse">Nurse</option>
                <option value="doctor">Doctor</option>
                <option value="assistant">Assistant</option>
            </select>

            <button class="px-4 py-2 bg-green-600 text-white rounded">
                Crear Usuario
            </button>
        </form>

    </div>
</x-app-layout>
