@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
        Editar Usuario
    </h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nombre</label>
            <input 
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
            >
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input 
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
            >
        </div>

        {{-- Rol --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Rol</label>

            <select 
                name="role"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required
            >
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="nurse" {{ $user->role == 'nurse' ? 'selected' : '' }}>Nurse</option>
                <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="assistant" {{ $user->role == 'assistant' ? 'selected' : '' }}>Assistant</option>
            </select>
        </div>

        {{-- Botón --}}
        <div class="pt-4 flex justify-between">

            <a href="{{ route('admin.users.index') }}"
               class="px-5 py-3 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">
               Cancelar
            </a>

            <button 
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition"
            >
                Guardar Cambios
            </button>
        </div>
    </form>

</div>

@endsection
