@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto mt-10 bg-white p-8 shadow-lg rounded-xl">

    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
        Mi Perfil
    </h1>

    <div class="space-y-4">

        <div>
            <p class="text-gray-600 font-medium">Nombre</p>
            <p class="text-lg text-gray-900">{{ auth()->user()->name }}</p>
        </div>

        <div>
            <p class="text-gray-600 font-medium">Email</p>
            <p class="text-lg text-gray-900">{{ auth()->user()->email }}</p>
        </div>

        <div>
            <p class="text-gray-600 font-medium">Rol</p>
            <p class="text-lg capitalize text-gray-900">{{ auth()->user()->role }}</p>
        </div>

    </div>

</div>

@endsection
