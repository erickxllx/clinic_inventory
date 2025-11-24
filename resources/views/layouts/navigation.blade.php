<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- LEFT: LOGO + NAV -->
            <div class="flex items-center space-x-10">

                <!-- LOGO -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-9 w-auto text-blue-600" />
                </a>

                <!-- NAV DESKTOP -->
                <div class="hidden sm:flex items-center space-x-6">

                    <a href="{{ route('dashboard') }}"
                       class="text-sm font-medium hover:text-blue-600 transition {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-600' }}">
                        Dashboard
                    </a>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.users.index') }}"
                               class="text-sm font-medium hover:text-blue-600 transition {{ request()->routeIs('admin.users.*') ? 'text-blue-600' : 'text-gray-600' }}">
                                Usuarios
                            </a>
                        @endif
                    @endauth
                    @auth
                        <a href="{{ route('products.index') }}"
                        class="text-sm font-medium hover:text-blue-600 transition {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-gray-600' }}">
                            Productos
                        </a>
                    @endauth

                </div>

                <!-- ACTION BUTTONS -->
                <div class="hidden sm:flex space-x-3">
                    <a href="{{ route('movements.create', ['type' => 'salida']) }}"
                       class="px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                        Registrar Venta
                    </a>

                    <a href="{{ route('movements.create', ['type' => 'entrada']) }}"
                       class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Nuevo Ingreso
                    </a>
                </div>

            </div>


            <!-- RIGHT: PROFILE DROPDOWN -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" fill="currentColor">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show')">Perfil</x-dropdown-link>

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


            <!-- MOBILE BUTTON -->
            <div class="flex sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-600 hover:bg-gray-200 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              d="M4 6h16M4 12h16M4 18h16" stroke-width="2" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                              d="M6 18L18 6M6 6l12 12" stroke-width="2" />
                    </svg>
                </button>
            </div>

        </div>
    </div>


    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t border-gray-200">

        <div class="py-2 px-4">
            <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.users.index')">Usuarios</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('products.index')">Productos</x-responsive-nav-link>
        </div>

        <!-- MOBILE ACTION BUTTONS -->
        <div class="px-4 pb-3 space-y-2">
            <a href="{{ route('movements.create', ['type' => 'salida']) }}"
               class="block text-center px-4 py-2 bg-red-600 text-white rounded-lg">
                Registrar Venta
            </a>

            <a href="{{ route('movements.create', ['type' => 'entrada']) }}"
               class="block text-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                Nuevo Ingreso
            </a>
        </div>

        <!-- USER INFO -->
        <div class="border-t border-gray-200 pt-4 pb-3 px-4">
            <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <x-responsive-nav-link :href="route('profile.show')">Perfil</x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Cerrar Sesión
                </x-responsive-nav-link>
            </form>
        </div>

    </div>

</nav>
