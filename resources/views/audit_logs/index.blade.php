<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
                    Historial de acciones
                </h2>
                <p class="text-sm text-gray-600">
                    Historial de acciones registradas en el sistema.
                </p>
            </div>

            <div class="flex items-center gap-2">
                @can('reports.export')
                    <a href="{{ route('reports.auditlogs.pdf', request()->query()) }}"
                       class="btn-dark-soft">
                        Exportar PDF
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Resumen --}}
            <div class="card p-5 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="text-sm text-gray-600">Total registros cargados</div>
                        <div class="text-2xl font-extrabold tracking-tight text-gray-900">
                            {{ method_exists($logs, 'total') ? $logs->total() : $logs->count() }}
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="status-pill bg-gray-100 text-gray-800">Auditoría</span>
                        <span class="status-pill bg-brand-100 text-brand-800">Trazabilidad</span>
                    </div>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="table-card">
                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th class="whitespace-nowrap">Fecha</th>
                                <th>Usuario</th>
                                <th>Módulo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    $mod = strtolower($log->modulo ?? '');
                                @endphp

                                <tr>
                                    <td class="whitespace-nowrap text-gray-600">
                                        {{ $log->fecha }}
                                    </td>

                                    <td class="font-medium text-gray-900">
                                        {{ $log->user?->name ?? '—' }}
                                    </td>

                                    <td>
                                        @if(str_contains($mod, 'activo'))
                                            <span class="status-ok">Activos</span>
                                        @elseif(str_contains($mod, 'custodio'))
                                            <span class="status-neutral">Custodios</span>
                                        @elseif(str_contains($mod, 'asign'))
                                            <span class="status-warn">Asignaciones</span>
                                        @elseif(str_contains($mod, 'manten'))
                                            <span class="status-pill bg-purple-100 text-purple-800">Mantenimientos</span>
                                        @elseif(str_contains($mod, 'marca') || str_contains($mod, 'catalog'))
                                            <span class="status-pill bg-indigo-100 text-indigo-800">Catálogos</span>
                                        @else
                                            <span class="status-pill bg-gray-100 text-gray-800">
                                                {{ $log->modulo ?? '—' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-gray-800">
                                        {{ $log->accion }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                        No hay registros en bitácora.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="p-4 sm:p-5 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>