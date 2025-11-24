<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-md">

    <!-- Contenedor Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- LOGO + LINKS -->
            <div class="flex items-center space-x-8">

                <!-- LOGO -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="block h-9 w-auto text-blue-700" />
                </a>

                <!-- MENU DESKTOP -->
                <div class="hidden sm:flex space-x-6">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                </div>

                <!-- BOTONES DESKTOP -->
                <a href="{{ route('admin.movements.create', ['type' => 'salida']) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                    Registrar Venta
                </a>

                <a href="{{ route('admin.movements.create', ['type' => 'entrada']) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Nuevo Ingreso
                </a>

            </div>

            <!-- USER MENU DESKTOP -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white hover:text-gray-900 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 h-4 w-4 fill-current"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>

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

            <!-- BOTÓN HAMBURGUESA -->
            <div class="flex sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-600 hover:bg-gray-200 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                              d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MENU RESPONSIVE -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t border-gray-200">

        <!-- Links principales -->
        <div class="pt-3 pb-2 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- ACCIONES RESPONSIVE -->
        <div class="px-4 pb-4 space-y-3">

            <!-- Registrar Venta -->
            <a href="{{ route('admin.movements.create', ['type' => 'salida']) }}"
               class="block w-full text-center px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                Registrar Venta
            </a>

            <!-- Nuevo Ingreso -->
            <a href="{{ route('admin.movements.create', ['type' => 'entrada']) }}"
               class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Nuevo Ingreso
            </a>
        </div>

        <!-- USER INFO RESPONSIVE -->
        <div class="border-t border-gray-200 pt-4 pb-1">

            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-600">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @can('isAdmin')
            <a href="{{ route('admin.users.index') }}"
                class="px-3 py-2 text-gray-700 hover:text-blue-600 transition">
                Usuarios
            </a>
        @endcan


    </div>

</nav>
