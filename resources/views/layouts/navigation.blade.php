<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto text-blue-700" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Action Buttons -->
                <div class="hidden sm:flex sm:items-center sm:ml-4 space-x-3">

                    <!-- Registrar Venta -->
                    <a href="{{ route('sales.create') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                        Registrar Venta
                    </a>

                    <!-- Registrar Ingreso -->
                    <a href="{{ route('products.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Nuevo Ingreso
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')"> Perfil </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-600 hover:bg-gray-200 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Action Buttons -->
        <div class="px-4 pb-4 space-y-3">
            <a href="{{ route('sales.create') }}"
               class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Registrar Venta
            </a>

            <a href="{{ route('products.create') }}"
               class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Nuevo Ingreso
            </a>
        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-gray-200 pt-4 pb-1">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"> Perfil </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
