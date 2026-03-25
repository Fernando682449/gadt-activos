<x-app-layout>
    <x-slot name="header">
        {{-- Línea institucional arriba --}}
        <div class="gadt-topline rounded-full mb-4"></div>

        {{-- Header tipo hero glass --}}
        <div class="hero-card p-5 sm:p-7">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-3">
                    {{-- mini escudo --}}
                    <div class="h-12 w-12 rounded-2xl bg-white border border-gray-200 shadow-soft flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/3.jpg') }}" alt="GADT" class="h-10 w-10 object-contain">
                    </div>

                    <div>
                        <h2 class="hero-title">Panel de Gestión de Activos</h2>
                        <p class="hero-subtitle">
                            Bienvenido, <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-500">Sistema GADT</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    @can('assets.create')
                        <a href="{{ route('assets.create') }}" class="btn-primary">
                            + Nuevo Activo
                        </a>
                    @endcan

                    @can('custodians.create')
                        <a href="{{ route('custodians.create') }}" class="btn-outline">
                            + Nuevo Custodio
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Fondo institucional + watermark --}}
    <div class="py-8 gadt-bg gadt-watermark">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Estadísticas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                @can('assets.view')
                    <div class="stat-pro p-5 border-t-4 border-blue-500">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Activos</div>
                                <div class="mt-2 text-3xl font-extrabold text-gray-900">
                                    {{ $countAssets ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500">Total registrados</div>
                            </div>
                            <div class="chip-circle bg-blue-50 text-blue-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h18M5 7v14h14V7M9 7V3h6v4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('custodians.view')
                    <div class="stat-pro p-5 border-t-4 border-emerald-500">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Custodios</div>
                                <div class="mt-2 text-3xl font-extrabold text-gray-900">
                                    {{ $countCustodians ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500">Total responsables</div>
                            </div>
                            <div class="chip-circle bg-emerald-50 text-emerald-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 14a4 4 0 10-8 0v6h8v-6zM12 10a4 4 0 100-8 4 4 0 000 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('assets.view')
                    <div class="stat-pro p-5 border-t-4 border-indigo-500">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Marcas</div>
                                <div class="mt-2 text-3xl font-extrabold text-gray-900">
                                    {{ $countBrands ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500">Catálogo</div>
                            </div>
                            <div class="chip-circle bg-indigo-50 text-indigo-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 7h10M7 11h10M7 15h6M5 21h14a2 2 0 002-2V7l-4-4H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('auditlogs.view')
                    <div class="stat-pro p-5 border-t-4 border-slate-600">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Historial de acciones</div>
                                <div class="mt-2 text-3xl font-extrabold text-gray-900">
                                    {{ $countAuditLogs ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500">Registros</div>
                            </div>
                            <div class="chip-circle bg-slate-100 text-slate-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2a4 4 0 014-4h2M7 7h10M7 11h6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>

            {{-- Módulos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @can('assets.view')
                    <a href="{{ route('assets.index') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Activos</p>
                                <p class="text-sm text-gray-600">Registrar, editar y listar activos</p>
                            </div>
                            <div class="chip-circle bg-blue-50 text-blue-700">
                                {{ $countAssets ?? '—' }}
                            </div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Acceso al listado y gestión.
                        </div>
                    </a>
                @endcan

                @can('custodians.view')
                    <a href="{{ route('custodians.index') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Custodios</p>
                                <p class="text-sm text-gray-600">Responsables de los activos</p>
                            </div>
                            <div class="chip-circle bg-emerald-50 text-emerald-700">
                                {{ $countCustodians ?? '—' }}
                            </div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Gestión de responsables y datos.
                        </div>
                    </a>
                @endcan

                @can('assignments.create')
                    <a href="{{ route('assignments.create') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Asignaciones</p>
                                <p class="text-sm text-gray-600">Asignar activos a custodios</p>
                            </div>
                            <div class="chip-circle bg-purple-50 text-purple-700">↗</div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Acceso directo al formulario.
                        </div>
                    </a>
                @endcan

                @can('maintenances.create')
                    <a href="{{ route('maintenances.create') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Mantenimientos</p>
                                <p class="text-sm text-gray-600">Registrar mantenimiento del activo</p>
                            </div>
                            <div class="chip-circle bg-amber-50 text-amber-700">↗</div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Preventivo / Correctivo.
                        </div>
                    </a>
                @endcan

                @can('auditlogs.view')
                    <a href="{{ route('audit-logs.index') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Historial de acciones</p>
                                <p class="text-sm text-gray-600">Registro de actividades del sistema</p>
                            </div>
                            <div class="chip-circle bg-slate-100 text-slate-700">
                                {{ $countAuditLogs ?? '—' }}
                            </div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Historial de acciones del sistema.
                        </div>
                    </a>
                @endcan

                @can('assets.view')
                    <a href="{{ route('brands.index') }}" class="module-pro p-6 block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-extrabold text-gray-900">Marcas</p>
                                <p class="text-sm text-gray-600">Catálogo de marcas para activos</p>
                            </div>
                            <div class="chip-circle bg-indigo-50 text-indigo-700">
                                {{ $countBrands ?? '—' }}
                            </div>
                        </div>
                        <div class="mt-4 soft-divider pt-3 text-xs text-gray-500">
                            Administración del catálogo.
                        </div>
                    </a>
                @endcan

            </div>

            {{-- Mensaje si no hay permisos --}}
            @if(
                !auth()->user()->can('assets.view') &&
                !auth()->user()->can('custodians.view') &&
                !auth()->user()->can('assignments.create') &&
                !auth()->user()->can('maintenances.create') &&
                !auth()->user()->can('auditlogs.view')
            )
                <div class="mt-8 card p-6 text-center text-gray-600">
                    No tienes permisos asignados para ver módulos todavía.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>