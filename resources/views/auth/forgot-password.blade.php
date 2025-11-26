<x-guest-layout>

    <!-- Caja Blanca del Formulario -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-gray-200">

        <!-- Título -->
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-4">
            Recuperar contraseña
        </h1>

        <!-- Texto descriptivo -->
        <p class="text-sm text-gray-600 mb-6 text-center leading-relaxed">
            ¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo y te enviaremos un enlace para crear una nueva.
        </p>

        <!-- Estado -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-600" />
                
                <x-text-input
                    id="email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    required
                    autofocus
                    class="block mt-1 w-full bg-gray-50 border border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500 text-gray-700"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
                Enviar enlace de recuperación
            </button>

            <!-- Enlace volver -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                    ← Volver al inicio de sesión
                </a>
            </div>

        </form>

    </div>

</x-guest-layout>
