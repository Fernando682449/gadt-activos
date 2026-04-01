<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex items-center gap-2">

                    <x-nav-link
                        href="{{ route('dashboard') }}"
                        :active="request()->routeIs('dashboard')"
                        class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                        Panel Principal
                    </x-nav-link>

                    @can('assets.view')
                        <x-nav-link
                            href="{{ route('assets.index') }}"
                            :active="request()->routeIs('assets.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            Activos
                        </x-nav-link>
                    @endcan

                    @can('assets.view')
                        <x-nav-link
                            :href="route('custody.index')"
                            :active="request()->routeIs('custody.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            {{ __('Activos en Custodia') }}
                        </x-nav-link>
                    @endcan

                    @can('custodians.view')
                        <x-nav-link
                            href="{{ route('custodians.index') }}"
                            :active="request()->routeIs('custodians.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            Custodios
                        </x-nav-link>
                    @endcan

                    @can('assignments.create')
                        <x-nav-link
                            href="{{ route('assignments.create') }}"
                            :active="request()->routeIs('assignments.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            Asignaciones
                        </x-nav-link>
                    @endcan

                    @can('maintenances.create')
                        <x-nav-link
                            href="{{ route('maintenances.create') }}"
                            :active="request()->routeIs('maintenances.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            Mantenimientos
                        </x-nav-link>
                    @endcan

                    @can('auditlogs.view')
                        <x-nav-link
                            href="{{ route('audit-logs.index') }}"
                            :active="request()->routeIs('audit-logs.*')"
                            class="px-3 py-2 rounded-xl text-sm font-medium transition hover:bg-gray-100">
                            Historial de acciones
                        </x-nav-link>
                    @endcan

                    @can('assets.view')
                        <div class="flex items-center">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                        <div>Catálogos</div>
                                        <svg class="fill-current h-4 w-4 opacity-80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 rounded-t-lg">
                                        Catálogos
                                    </div>

                                    <x-dropdown-link href="{{ route('brands.index') }}" class="hover:bg-indigo-50 hover:text-indigo-700 transition">
                                        Marcas
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcan

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 px-3 py-2 text-sm bg-white/70 backdrop-blur border border-gray-200 rounded-full shadow-sm hover:shadow-md hover:border-indigo-300 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-indigo-400 shadow-sm"
                                     src="{{ Auth::user()->profile_photo_url }}"
                                     alt="{{ Auth::user()->name }}" />

                                <div class="hidden md:flex flex-col items-start leading-tight">
                                    <span class="text-gray-800 font-semibold">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ Auth::user()->email }}
                                    </span>
                                </div>

                                <svg class="hidden md:block fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 rounded-t-lg">
                                Cuenta
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}" class="hover:bg-indigo-50 hover:text-indigo-700 transition">
                                Perfil
                            </x-dropdown-link>

                            @role('Administrador')
                                <x-dropdown-link href="{{ route('users.create') }}" class="hover:bg-indigo-50 hover:text-indigo-700 transition">
                                    Nuevo Usuario
                                </x-dropdown-link>
                            @endrole

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/90 backdrop-blur border-t border-gray-200">
        <div class="pt-3 pb-3 space-y-1 px-3">

            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Panel Principal
            </x-responsive-nav-link>

            @can('assets.view')
                <x-responsive-nav-link href="{{ route('assets.index') }}" :active="request()->routeIs('assets.*')">
                    Activos
                </x-responsive-nav-link>
            @endcan

            @can('assets.view')
                <x-responsive-nav-link :href="route('custody.index')" :active="request()->routeIs('custody.*')">
                    Activos en Custodia
                </x-responsive-nav-link>
            @endcan

            @can('custodians.view')
                <x-responsive-nav-link href="{{ route('custodians.index') }}" :active="request()->routeIs('custodians.*')">
                    Custodios
                </x-responsive-nav-link>
            @endcan

            @can('assignments.create')
                <x-responsive-nav-link href="{{ route('assignments.create') }}" :active="request()->routeIs('assignments.*')">
                    Asignaciones
                </x-responsive-nav-link>
            @endcan

            @can('maintenances.create')
                <x-responsive-nav-link href="{{ route('maintenances.create') }}" :active="request()->routeIs('maintenances.*')">
                    Mantenimientos
                </x-responsive-nav-link>
            @endcan

            @can('auditlogs.view')
                <x-responsive-nav-link href="{{ route('audit-logs.index') }}" :active="request()->routeIs('audit-logs.*')">
                    Historial de acciones
                </x-responsive-nav-link>
            @endcan

            @can('assets.view')
                <div class="mt-3 border-t border-gray-200 pt-3">
                    <div class="px-2 text-xs text-gray-400 uppercase tracking-wider">
                        Catálogos
                    </div>

                    <x-responsive-nav-link href="{{ route('brands.index') }}" :active="request()->routeIs('brands.*')">
                        Marcas
                    </x-responsive-nav-link>
                </div>
            @endcan

        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="px-4">
                <div class="font-semibold text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-3">
                <x-responsive-nav-link href="{{ route('profile.show') }}">
                    Perfil
                </x-responsive-nav-link>

                @role('Administrador')
                    <x-responsive-nav-link href="{{ route('users.create') }}">
                        Nuevo Usuario
                    </x-responsive-nav-link>
                @endrole

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-600">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>