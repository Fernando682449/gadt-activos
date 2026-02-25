<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Panel de Gestión de Activos
                </h2>
                <p class="text-sm text-gray-500">
                    Bienvenido, <span class="font-semibold">{{ Auth::user()->name }}</span>
                </p>
            </div>

            <div class="flex gap-2 mt-3 sm:mt-0">
                @can('assets.create')
                    <a href="{{ route('assets.create') }}"
                       class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        + Nuevo Activo
                    </a>
                @endcan

                @can('custodians.create')
                    <a href="{{ route('custodians.create') }}"
                       class="px-4 py-2 rounded-lg border text-sm font-medium hover:bg-gray-50 transition">
                        + Nuevo Custodio
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ Estadísticas rápidas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @can('assets.view')
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="text-sm text-gray-500">Activos</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $countAssets ?? '—' }}
                        </div>
                        <div class="mt-2 text-xs text-gray-500">Total registrados</div>
                    </div>
                @endcan

                @can('custodians.view')
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="text-sm text-gray-500">Custodios</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $countCustodians ?? '—' }}
                        </div>
                        <div class="mt-2 text-xs text-gray-500">Total responsables</div>
                    </div>
                @endcan

                {{-- ✅ NUEVO: Marcas --}}
                @can('assets.view')
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="text-sm text-gray-500">Marcas</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $countBrands ?? '—' }}
                        </div>
                        <div class="mt-2 text-xs text-gray-500">Catálogo</div>
                    </div>
                @endcan

                @can('auditlogs.view')
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <div class="text-sm text-gray-500">Bitácora</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900">
                            {{ $countAuditLogs ?? '—' }}
                        </div>
                        <div class="mt-2 text-xs text-gray-500">Registros</div>
                    </div>
                @endcan
            </div>

            {{-- ✅ Tarjetas principales (módulos) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Activos --}}
                @can('assets.view')
                    <a href="{{ route('assets.index') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-blue-700">Activos</p>
                                <p class="text-sm text-gray-500">Registrar, editar y listar activos</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h18M5 7v14h14V7M9 7V3h6v4" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total</span>
                            <span class="font-semibold text-gray-900">{{ $countAssets ?? '—' }}</span>
                        </div>
                    </a>
                @endcan

                {{-- Custodios --}}
                @can('custodians.view')
                    <a href="{{ route('custodians.index') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-emerald-700">Custodios</p>
                                <p class="text-sm text-gray-500">Responsables de los activos</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 14a4 4 0 10-8 0v6h8v-6zM12 10a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total</span>
                            <span class="font-semibold text-gray-900">{{ $countCustodians ?? '—' }}</span>
                        </div>
                    </a>
                @endcan

                {{-- Asignaciones --}}
                @can('assignments.create')
                    <a href="{{ route('assignments.create') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-purple-700">Asignaciones</p>
                                <p class="text-sm text-gray-500">Asignar activos a custodios</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-purple-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7h8M8 11h8M8 15h6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-500">
                            Acceso directo al formulario
                        </div>
                    </a>
                @endcan

                {{-- Mantenimientos --}}
                @can('maintenances.create')
                    <a href="{{ route('maintenances.create') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Mantenimientos</p>
                                <p class="text-sm text-gray-500">Registrar mantenimiento del activo</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14.7 6.3l3 3-8.4 8.4H6.3v-3l8.4-8.4zM16 5l3 3" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-500">
                            Acceso directo al formulario
                        </div>
                    </a>
                @endcan

                {{-- Bitácora --}}
                @can('auditlogs.view')
                    <a href="{{ route('audit-logs.index') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-slate-800">Bitácora</p>
                                <p class="text-sm text-gray-500">Registro de actividades (auditoría)</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-slate-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2a4 4 0 014-4h2M7 7h10M7 11h6" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Registros</span>
                            <span class="font-semibold text-gray-900">{{ $countAuditLogs ?? '—' }}</span>
                        </div>
                    </a>
                @endcan

                {{-- ✅ NUEVO: Catálogo Marcas --}}
                @can('assets.view')
                    <a href="{{ route('brands.index') }}"
                       class="group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700">Marcas</p>
                                <p class="text-sm text-gray-500">Catálogo de marcas para activos</p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 7h10M7 11h10M7 15h6M5 21h14a2 2 0 002-2V7l-4-4H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total</span>
                            <span class="font-semibold text-gray-900">{{ $countBrands ?? '—' }}</span>
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
                <div class="mt-8 bg-white border border-gray-200 rounded-2xl p-6 text-center text-gray-600">
                    No tienes permisos asignados para ver módulos todavía.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>