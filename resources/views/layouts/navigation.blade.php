<nav x-data="{ open: false }" class="w-full">

    {{-- ====== BANDA SUPERIOR TIPO PORTAL (FONDO + IMAGEN) ====== --}}
    <div class="relative overflow-hidden">
        <div class="h-16 md:h-20 w-full bg-gradient-to-r from-brand-700 via-brand-600 to-brand-700">
            {{-- Imagen de fondo opcional --}}
            <div class="absolute inset-0 opacity-20"
                 style="background-image:url('{{ asset('public/img/4.jpg') }}'); background-size:cover; background-position:center;">
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
                {{-- Branding izquierda --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('img/4.png') }}"
                         class="h-10 w-10 md:h-12 md:w-12 rounded bg-white/85 p-1 shadow-sm"
                         alt="Escudo">

                    <div class="leading-tight text-white">
                        <div class="font-extrabold tracking-wide text-sm md:text-base">GADT - Tarija</div>
                        <div class="text-[11px] md:text-xs opacity-90">Sistema de Gestión de Activos</div>
                    </div>
                </a>

                {{-- Botón hamburguesa móvil --}}
                <button @click="open = !open"
                        class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-white/90 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/40">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ====== NAVBAR BLANCO (SUBMENÚ) ====== --}}
    <div class="bg-white/90 backdrop-blur border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                {{-- LINKS DESKTOP --}}
                <div class="hidden md:flex items-center gap-2">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                        Dashboard
                    </a>

                    {{-- Dropdown Activos (hover) --}}
                    <div class="relative group">
                        <button type="button"
                                class="nav-link {{ request()->routeIs('assets.*') ? 'nav-link-active' : '' }} inline-flex items-center gap-1">
                            Activos
                            <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div class="absolute left-0 mt-2 w-56 rounded-xl border border-gray-200 bg-white shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                            <a href="{{ route('assets.index') }}" class="dropdown-item">
                                Ver Activos
                            </a>
                            <a href="{{ route('assets.create') }}" class="dropdown-item">
                                Crear Activo
                            </a>
                        </div>
                    </div>

                    {{-- Custodios --}}
                    <a href="{{ route('custodians.index') }}"
                       class="nav-link {{ request()->routeIs('custodians.*') ? 'nav-link-active' : '' }}">
                        Custodios
                    </a>

                    {{-- Asignaciones --}}
                    <a href="{{ route('assignments.create') }}"
                       class="nav-link {{ request()->routeIs('assignments.*') ? 'nav-link-active' : '' }}">
                        Asignaciones
                    </a>

                    {{-- Mantenimientos --}}
                    <a href="{{ route('maintenances.create') }}"
                       class="nav-link {{ request()->routeIs('maintenances.*') ? 'nav-link-active' : '' }}">
                        Mantenimientos
                    </a>

                    {{-- Bitácora (si tienes ruta) --}}
                    @if (Route::has('audit-logs.index'))
                        <a href="{{ route('audit-logs.index') }}"
                           class="nav-link {{ request()->routeIs('audit-logs.*') ? 'nav-link-active' : '' }}">
                            Historial de acciones
                        </a>
                    @endif

                    {{-- Catálogos (si tienes dropdown) --}}
                    @if (Route::has('brands.index'))
                        <a href="{{ route('brands.index') }}"
                           class="nav-link {{ request()->routeIs('brands.*') ? 'nav-link-active' : '' }}">
                            Catálogos
                        </a>
                    @endif

                </div>

                {{-- PERFIL / DROPDOWN (DESKTOP) --}}
                <div class="hidden md:flex md:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-semibold text-gray-700 transition">
                                <div class="h-8 w-8 rounded-full bg-brand-100 text-brand-800 grid place-items-center font-bold">
                                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                                </div>
                                <div class="hidden lg:block">{{ Auth::user()->name }}</div>
                                <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

            </div>
        </div>

        {{-- ====== MENÚ RESPONSIVE (MÓVIL) ====== --}}
        <div x-show="open" x-transition class="md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="mobile-link {{ request()->routeIs('dashboard') ? 'mobile-link-active' : '' }}">Dashboard</a>

                <div class="pt-2">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wide px-2">Activos</div>
                    <a href="{{ route('assets.index') }}" class="mobile-link {{ request()->routeIs('assets.index') ? 'mobile-link-active' : '' }}">Ver Activos</a>
                    <a href="{{ route('assets.create') }}" class="mobile-link {{ request()->routeIs('assets.create') ? 'mobile-link-active' : '' }}">Crear Activo</a>
                </div>

                <a href="{{ route('custodians.index') }}" class="mobile-link {{ request()->routeIs('custodians.*') ? 'mobile-link-active' : '' }}">Custodios</a>
                <a href="{{ route('assignments.create') }}" class="mobile-link {{ request()->routeIs('assignments.*') ? 'mobile-link-active' : '' }}">Asignaciones</a>
                <a href="{{ route('maintenances.create') }}" class="mobile-link {{ request()->routeIs('maintenances.*') ? 'mobile-link-active' : '' }}">Mantenimientos</a>

                @if (Route::has('audit-logs.index'))
                    <a href="{{ route('audit-logs.index') }}" class="mobile-link {{ request()->routeIs('audit-logs.*') ? 'mobile-link-active' : '' }}">Bitácora</a>
                @endif

                @if (Route::has('brands.index'))
                    <a href="{{ route('brands.index') }}" class="mobile-link {{ request()->routeIs('brands.*') ? 'mobile-link-active' : '' }}">Catálogos</a>
                @endif
            </div>

            <div class="border-t border-gray-200 px-4 py-3">
                <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="mobile-link">Perfil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-link text-left w-full">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</nav>