<x-guest-layout>
    <!-- Fondo blanco profesional -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

        <!-- Caja del login -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-gray-200">

            <!-- Título / Logo -->
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-6 tracking-wide">
                Clínica Angel
            </h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full bg-gray-50 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full bg-gray-50 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-400"
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Botón Login -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
                    {{ __('Log in') }}
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>
