<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Gestión de Activos
            </h2>
            <span class="text-sm text-gray-500">
                Bienvenido, <span class="font-semibold">{{ Auth::user()->name }}</span>
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Tarjetas (botones) centradas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Activos --}}
                @can('assets.view')
                    <a href="{{ route('assets.index') }}"
                       class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7h18M5 7v14h14V7M9 7V3h6v4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-blue-700">Activos</p>
                                <p class="text-sm text-gray-500">Registrar, editar y listar activos</p>
                            </div>
                        </div>
                    </a>
                @endcan

                {{-- Custodios --}}
                @can('custodians.view')
                    <a href="{{ route('custodians.index') }}"
                       class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 14a4 4 0 10-8 0v6h8v-6zM12 10a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-emerald-700">Custodios</p>
                                <p class="text-sm text-gray-500">Responsables de los activos</p>
                            </div>
                        </div>
                    </a>
                @endcan

                {{-- Asignaciones --}}
                @can('assignments.create')
                    <a href="{{ route('assignments.create') }}"
                       class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-purple-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7h8M8 11h8M8 15h6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-purple-700">Asignaciones</p>
                                <p class="text-sm text-gray-500">Asignar activos a custodios</p>
                            </div>
                        </div>
                    </a>
                @endcan

                {{-- Mantenimientos --}}
                @can('maintenances.create')
                    <a href="{{ route('maintenances.create') }}"
                       class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-amber-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14.7 6.3l3 3-8.4 8.4H6.3v-3l8.4-8.4zM16 5l3 3" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-amber-700">Mantenimientos</p>
                                <p class="text-sm text-gray-500">Registrar mantenimiento del activo</p>
                            </div>
                        </div>
                    </a>
                @endcan

                {{-- Bitácora --}}
                @can('auditlogs.view')
                    <a href="{{ route('audit-logs.index') }}"
                       class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center">
                                <svg class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2a4 4 0 014-4h2M7 7h10M7 11h6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900 group-hover:text-slate-800">Bitácora</p>
                                <p class="text-sm text-gray-500">Registro de actividades (auditoría)</p>
                            </div>
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
                <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6 text-center text-gray-600">
                    No tienes permisos asignados para ver módulos todavía.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
